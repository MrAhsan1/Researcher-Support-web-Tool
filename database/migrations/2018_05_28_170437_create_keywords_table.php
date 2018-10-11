<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeywordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void 
     */
    public function up()
    {
        Schema::create('keywords', function (Blueprint $table) {
            $table->increments('id');
            $table->string('keywords',5000);
            $table->integer('researchpaper_id')->unsigned();
            $table->timestamps();
        });
        DB::statement('ALTER TABLE keywords ADD FULLTEXT INDEX Indexkeywords (keywords)');
        Schema::table('keywords', function (Blueprint $table) {
            $table->foreign('researchpaper_id')->references('id')->on('research_papers')->onDelete('cascade');
        });



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('keywords');
    }
}
