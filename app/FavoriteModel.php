<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FavoriteModel extends Model
{
    public function user()
    {
        return $this->belongsToMany('App\User');
    }
    public function researchpaper()
    {
        return $this->belongsTo('App\ResearchPapers');
    }
}
