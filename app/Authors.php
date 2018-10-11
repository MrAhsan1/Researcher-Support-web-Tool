<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Authors extends Model
{
    public function researchpaper()
    {
    	return $this->belongsTo('App\ResearchPapers');
    }
}
