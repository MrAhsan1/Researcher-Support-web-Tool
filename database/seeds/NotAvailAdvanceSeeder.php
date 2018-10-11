<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\NotAvailAdvance;
class NotAvailAdvanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data1 = NotAvailAdvance::get();
         DB::table('not_avail_advances')->truncate();
         //insert some dummy records
         foreach($data1 as $user){
         DB::table('not_avail_advances')->insert(array(
             array('titles'=>$user->titles,'dates'=>$user->dates,'authors'=>$user->authors)
          ));
    }
    }
}
