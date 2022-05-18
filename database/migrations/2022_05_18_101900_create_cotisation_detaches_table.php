<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCotisationDetachesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotisation_detaches', function (Blueprint $table) {
            $table->id();
            $table->string('matricule');
            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->string('telephone')->nullable();
            $table->integer('mois');
            $table->integer('annee');
            $table->double('cotisation_employee', 64,2)->default(0);
            $table->double('salaire_base',64,2)->default(0);
            $table->double('points',64,2)->default(0);
            $table->foreignId('user_id');
            $table->foreignId('detache_id')->nullable();
            $table->foreignId('institution_id')->nullable();
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
        Schema::dropIfExists('cotisation_detaches');
    }
}
