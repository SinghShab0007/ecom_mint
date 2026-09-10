<?php

use App\Models\Backend\Language;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SeedLanguageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('languages', function (Blueprint $table) {
            $languages = [
                'en' => [
                    'name' => 'English',
                    'alias' => 'en',
                    'direction' => 'ltr',
                    'default' => 1,
                    'is_active' => 1
                ],
            ];

            foreach ($languages as $language){
                Language::query()->create($language);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('languages', function (Blueprint $table) {
            //
        });
    }
}
