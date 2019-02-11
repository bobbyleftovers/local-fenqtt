<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use App\Models\LiteBriteConfig;
class Submissions extends Model
{
    public $table = "submissions";

    // if the site exists in the Websites collection, add it here too
    // public function config()
    // {
    //     return $this->hasOne('App\Models\LiteBriteConfig', 'id', 'config_id');
    // }
}