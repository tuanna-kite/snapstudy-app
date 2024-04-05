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
        Schema::table('users', function (Blueprint $table) {
            $table->string('code')->nullable()->after('location');
            $table->boolean('enable_email_comment')->default(false);
            $table->boolean('enable_email_answers')->default(false);
            $table->boolean('enable_email_follow')->default(false);
            $table->boolean('enable_email_new')->default(false);
            $table->boolean('enable_email_product_update')->default(false);
            $table->boolean('enable_email_blog_weekly')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('code');
            $table->dropColumn('enable_email_comment');
            $table->dropColumn('enable_email_answers');
            $table->dropColumn('enable_email_follow');
            $table->dropColumn('enable_email_new');
            $table->dropColumn('enable_email_product_update');
            $table->dropColumn('enable_email_blog_weekly');
        });
    }
};
