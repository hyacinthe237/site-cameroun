<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBilletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('table_id');
            $table->string('name');
            $table->string('code');
            $table->enum('type', ['Couple', 'Single']);
            $table->enum('civilite', ['M.', 'Mme.', 'M. & Mme']);
            $table->boolean('is_entered')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('billets');
    }
}
