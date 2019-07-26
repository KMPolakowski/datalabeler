<?php

namespace App\Models;

use App\Models\ForeignMinistryPage;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class ForeignMinistry extends Model
{
    public function ForeignMinistryPages()
    {
        return $this->hasMany(ForeignMinistryPage::class);
    }
}
