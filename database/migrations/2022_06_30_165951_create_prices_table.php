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
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prices_group_id');
            $table->string('name');
            $table->integer('duration')->nullable();
            $table->integer('price');
            $table->integer('order')->nullable()->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->foreign('prices_group_id')
                ->references('id')->on('prices_groups')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prices');
    }
};
