<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetachesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detaches', function (Blueprint $table) {
            $table->id();
            $table->string("nom")->nullable();
            $table->string("prenom")->nullable();
            $table->string("matricule");
            $table->string("telephone")->nullable();
            $table->double("salaire_base", 64,2)->default(0);
            $table->string("email")->nullable();
            $table->string("debut_travail")->nullable();
            $table->foreignId("institution_id")->nullable();
            $table->foreignId("user_id")->nullable();
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
        Schema::dropIfExists('detaches');
    }
}
