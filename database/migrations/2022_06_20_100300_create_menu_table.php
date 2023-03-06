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
        Schema::create('menu', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->unsigned()->nullable()->index();
            $table->integer('simple_page_id')->nullable();
            $table->integer('news_item_id')->nullable();
            $table->integer('sport_school_id')->nullable();
            $table->string('title');
            $table->string('type')->nullable();
            $table->string('route')->nullable();
            $table->string('url')->nullable();
            $table->integer('order')->nullable()->default('0');
            $table->boolean('active')->default(true);
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
        Schema::dropIfExists('menu');
    }
};
