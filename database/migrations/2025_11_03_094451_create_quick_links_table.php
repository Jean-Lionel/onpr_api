<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuickLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quick_links', function (Blueprint $table) {
            $table->id();
            $table->string('name_en')->nullable();
            $table->string('name_fr')->nullable();
            $table->string('description_en')->nullable();
            $table->string('description_fr')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address_en')->nullable();
            $table->string('address_fr')->nullable();
            $table->string('box')->nullable();
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
        Schema::dropIfExists('quick_links');
    }
}
