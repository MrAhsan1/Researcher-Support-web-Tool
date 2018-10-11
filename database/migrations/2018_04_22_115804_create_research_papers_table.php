<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResearchPapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('research_papers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('abstract',9000);
            $table->string('title',3000);
            $table->string('paperlinks',1000);
            $table->string('dates');
            $table->string('doi',1000);
            $table->string('research_areas',100);
            $table->string('websites',1000);

            $table->timestamps();

        });
        DB::statement('ALTER TABLE research_papers ADD FULLTEXT INDEX Indexpaperstitle (title)');
        DB::statement('ALTER TABLE research_papers ADD FULLTEXT INDEX Indexpaperabstract (abstract)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('research_papers');
    }
}
