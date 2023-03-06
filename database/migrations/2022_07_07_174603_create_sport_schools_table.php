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
        Schema::create('sport_schools', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('icon')->nullable();
            $table->boolean('main')->default(false);
            $table->text('main_text')->nullable();
            $table->string('banner');
            $table->text('banner_text');
            $table->boolean('banner_form');
            $table->string('desc_title');
            $table->longText('desc_text');
            $table->string('desc_image');
            $table->longText('gallery');
            $table->unsignedBigInteger('schedule_id')->nullable();
            $table->integer('order')->nullable()->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->foreign('schedule_id')
                ->references('id')->on('schedule')
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
        Schema::dropIfExists('sport_schools');
    }
};
