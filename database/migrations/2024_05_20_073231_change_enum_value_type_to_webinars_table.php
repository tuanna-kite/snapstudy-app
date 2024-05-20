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
        Schema::table('webinars', function (Blueprint $table) {
            $table->enum('type', ['webinar', 'course', 'text_lesson'])->after('category_id');
        });

    }

    /**
     * Reverse the migrations.
     *m
     * @return void
     */
    public function down()
    {
        Schema::table('webinars', function (Blueprint $table) {
            //
        });
    }
};
