<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    public function researchpaper()
    {
    	return $this->belongsTo('App\ResearchPapers');
    }

}
