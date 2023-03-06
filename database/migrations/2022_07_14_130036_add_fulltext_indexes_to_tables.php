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
        DB::statement('ALTER TABLE galleries ADD FULLTEXT fulltext_index (name)');
        DB::statement('ALTER TABLE news_items ADD FULLTEXT fulltext_index (name, text)');
        DB::statement('ALTER TABLE services ADD FULLTEXT fulltext_index (name, text)');
        DB::statement('ALTER TABLE simple_pages ADD FULLTEXT fulltext_index (title, text)');
        DB::statement('ALTER TABLE sport_schools ADD FULLTEXT fulltext_index (name, main_text, banner_text, desc_text)');
        DB::statement('ALTER TABLE vacancies ADD FULLTEXT fulltext_index (name, full_text)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP INDEX fulltext_index ON galleries');
        DB::statement('DROP INDEX fulltext_index ON news_items');
        DB::statement('DROP INDEX fulltext_index ON services');
        DB::statement('DROP INDEX fulltext_index ON simple_pages');
        DB::statement('DROP INDEX fulltext_index ON sport_schools');
        DB::statement('DROP INDEX fulltext_index ON vacancies');
    }
};
