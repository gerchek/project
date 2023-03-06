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
        Schema::create('news_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('news_group_id');
            $table->string('slug');
            $table->string('image');
            $table->longText('text');
            $table->dateTime('date')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->foreign('news_group_id')
                ->references('id')->on('news_groups')
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
        Schema::dropIfExists('news_items');
    }
};
