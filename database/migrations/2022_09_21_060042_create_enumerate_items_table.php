<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enumerate_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title');
            $table->string('value');
            $table->string('value_alt')->nullable();
            $table->string('value_alt_2')->nullable();
            $table->bigInteger('sequence');
            $table->boolean('is_enabled');
            $table->foreignId('enumerate_id')->constrained('enumerate')->cascadeOnDelete();
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
        Schema::dropIfExists('config_items');
    }
};
