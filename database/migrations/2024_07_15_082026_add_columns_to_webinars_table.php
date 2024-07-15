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
            $table->string('genre')->after('type')->nullable();
            $table->integer('assigned_user')->unsigned()->nullable();
            $table->float('implementation_cost', 15, 3)->after('price')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('webinars', function (Blueprint $table) {
            $table->dropColumn('genre');
            $table->dropColumn('assigned_user');
            $table->dropColumn('implementation_cost');
        });
    }
};
