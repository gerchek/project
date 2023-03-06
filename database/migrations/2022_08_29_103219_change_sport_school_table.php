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
        Schema::table('sport_schools', function (Blueprint $table)
        {
            $table->dropColumn('desc_image');
            $table->longText('desc_images')->after('desc_text');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sport_schools', function (Blueprint $table)
        {
            $table->dropColumn('desc_images');
            $table->string('desc_image')->after('desc_text');
        });
    }
};
