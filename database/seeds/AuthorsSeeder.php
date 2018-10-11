<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Authors;
class AuthorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $data1 = Authors::get();
         DB::table('authors')->truncate();
         //insert some dummy records
         foreach($data1 as $user){
         DB::table('authors')->insert(array(
             array('authors'=>$user->authors,'researchpaper_id'=>$user->researchpaper_id)
          ));
    }
}
}
