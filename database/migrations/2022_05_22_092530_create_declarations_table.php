<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeclarationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('declarations', function (Blueprint $table) {
            $table->id();
            $table->string("nom_instution");
            $table->string("adresse");
            $table->string("telephone");
            $table->string("email")->nullable();
            //Employeur
            $table->string("nom_declarant");
            $table->text("motif_declaration");
            $table->date("date_declaration");
            $table->string("victime_name");
            $table->string("victime_prenom");
            $table->string("victime_matricule")->nullable();
            $table->string("victime_telephone")->nullable();
            $table->string("file_name_1");
            $table->string("file_justification_1");
            $table->string("file_name_2")->nullable();
            $table->string("file_justification_2")->nullable();
            $table->string("file_name_3")->nullable();
            $table->string("file_justification_3")->nullable();
            $table->boolean("is_opened")->default(false);
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
        Schema::dropIfExists('declarations');
    }
}
