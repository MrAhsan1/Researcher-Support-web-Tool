<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Keyword;
class KeywordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data1 = Keyword::get();
         DB::table('keywords')->truncate();
         //insert some dummy records
         foreach($data1 as $user){
         DB::table('keywords')->insert(array(
             array('keywords'=>$user->keywords,'researchpaper_id'=>$user->researchpaper_id,'created_at'=>$user->created_at,'updated_at'=>$user->updated_at)
          ));
    }
    }
}
