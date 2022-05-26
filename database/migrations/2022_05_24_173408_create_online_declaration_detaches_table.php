<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnlineDeclarationDetachesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_declaration_detaches', function (Blueprint $table) {
            $table->id();
            $table->string('titre')->nullable();
            $table->string('code_instution');
            $table->string('nom_instution');
            $table->string('mois');
            $table->string('annee');
            $table->date('date_declaration');
            $table->longText('description')->nullable();
            $table->string('file_name_one')->nullable();
            $table->string('file_uploaded_one');
            $table->string('file_name_two')->nullable();
            $table->string('file_uploaded_two')->nullable();
            $table->string('file_name_three')->nullable();
            $table->string('file_uploaded_three')->nullable();
            $table->foreignId('user_id');
            $table->foreignId('institution_id');
            $table->boolean('is_opened')->default(false);
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
        Schema::dropIfExists('online_declaration_detaches');
    }
}
