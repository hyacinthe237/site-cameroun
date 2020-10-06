<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEtudiantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etudiants', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->integer('niveau_id')->unsigned();
          $table->bigInteger('number')->index();
          $table->string('firstname');
          $table->string('lastname')->nullable();
          $table->string('phone')->nullable();
          $table->string('email')->unique();
          $table->string('sex')->nullable();
          $table->string('dob')->nullable();
          $table->boolean('is_active')->default(true);
          $table->timestamps();
          $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('etudiants');
    }
}
