<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Person;
use App\Models\Location;
use App\Models\PagePiece;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\EventPerson;
use Illuminate\Database\Connection;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function addEventOfPagePiece(Request $request, int $pagePieceId, string $labeledBy)
    {
        $result = "success";
        $msg = "labeled successfully";

        try {
            $pagePiece = PagePiece::findOrFail($pagePieceId);

            if (empty(implode("", $request->get("people")))) {
                $pagePiece->labeled_by = $labeledBy;
                $pagePiece->saveOrFail();

                return \redirect("/to-label/" . $labeledBy)->with($result, $msg);
            }

            $people = [];

            foreach ($request->get("people") as $person) {
                if (empty($person)) {
                    continue;
                }

                $newPerson = new Person;
                $newPerson->name = $person;
                $newPerson->saveOrFail();
                $people[] = $newPerson;
            }

            $location = new Location;
            $location->name = $request->get("location");
            $location->saveOrFail();

            $event = new Event;

            $event->happening_at = $request->get("happening_at");
            $event->published_at = $request->get("published_at");
            $event->location_id = $location->id;
            $event->type = $request->get("type");
            $event->saveOrFail();


            foreach ($people as &$person) {
                $eventPerson = new EventPerson();
                $eventPerson->person_id = $person->id;
                $eventPerson->event_id = $event->id;
                $eventPerson->saveOrFail();
            }

            $pagePiece = PagePiece::find($pagePieceId);
            $pagePiece->event_id = $event->id;
            $pagePiece->labeled_by = $labeledBy;
            $pagePiece->saveOrFail();
        } catch (\PDOException $e) {
            $result = "failure";
            $msg = $e->getMessage();
        }

        return \redirect("/to-label/" . $labeledBy)->with($result, $msg);
    }

    public function showPagePieceToBeLabeled(Connection $conn, string $author)
    {
        $query =
            <<<SQL
SELECT 
    `pp0`.`html`, `pp0`.`id`
FROM
    page_piece AS `pp0`
        INNER JOIN
    foreign_ministry_page AS `fmp0` ON `fmp0`.`id` = `pp0`.`foreign_ministry_page_id`
        INNER JOIN
    foreign_ministries AS `fm0` ON `fm0`.`id` = `fmp0`.`foreign_ministry_id`
WHERE 
	1=1
		AND `pp0`.`labeled_by` IS NULL
HAVING (
	SELECT 
        COUNT(*)
    FROM
        page_piece AS `pp1`
            INNER JOIN
        foreign_ministry_page AS `fmp1` ON `fmp1`.`id` = `pp1`.`foreign_ministry_page_id`
            INNER JOIN
        foreign_ministries AS `fm1` ON `fm1`.`id` = `fmp1`.`foreign_ministry_id`
    WHERE
        1 = 1 
			AND `fm1`.`id` = `fm0`.`id`
            AND `pp1`.`labeled_by` IS NOT NULL
    ) <= 200
LIMIT 1;
SQL;

        $pagePiece = $conn->selectOne($query);

        return view(
            'label_page_piece',
            [
                "page_piece" => $pagePiece,
                "author" => $author
            ]
        );
    }
}
