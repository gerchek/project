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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_group_id');
            $table->string('name');
            $table->string('post');
            $table->string('photo');
            $table->text('short_text')->nullable();
            $table->longText('full_text')->nullable();
            $table->integer('order')->nullable()->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->foreign('employee_group_id')
                ->references('id')->on('employee_groups')
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
        Schema::dropIfExists('employees');
    }
};
