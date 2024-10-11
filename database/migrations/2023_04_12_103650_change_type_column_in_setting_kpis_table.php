<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTypeColumnInSettingKpisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('setting_kpis', function (Blueprint $table) {
            $table->integer("post_edit_num")->nullable()->change();
            $table->integer("post_publish_num")->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('setting_kpis', function (Blueprint $table) {
            $table->integer("post_edit_num")->change();
            $table->integer("post_publish_num")->change();
        });
    }
}
