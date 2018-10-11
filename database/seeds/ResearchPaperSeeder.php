<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\ResearchPapers;
class ResearchPaperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $data1 = ResearchPapers::get();
         DB::table('research_papers')->truncate();
         //insert some dummy records
         foreach($data1 as $user){
         DB::table('research_papers')->insert(array(
             array('abstract'=>$user->abstract,'title'=>$user->title,'paperlinks'=>$user->paperlinks,'dates'=>$user->dates,'doi'=>$user->doi)
          ));
    }
    }
}
