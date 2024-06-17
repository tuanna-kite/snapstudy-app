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
        Schema::table('quizzes_questions', function (Blueprint $table) {
            $table->string('title_image')->nullable()->after('image');
            $table->string('correct_image')->nullable()->after('title_image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quizzes_questions', function (Blueprint $table) {
            $table->dropColumn('title_image');
            $table->dropColumn('correct_image');
        });
    }
};
