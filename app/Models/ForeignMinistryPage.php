<?php

namespace App\Models;

use App\Models\PagePiece;
use App\Models\ForeignMinistry;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class ForeignMinistryPage extends Model
{
    protected $table = "foreign_ministry_page";

    public function PagePiece()
    {
        return $this->hasMany(PagePiece::class);
    }

    public function ForeignMinistry()
    {
        return $this->belongsTo(ForeignMinistry::class);
    }
}
