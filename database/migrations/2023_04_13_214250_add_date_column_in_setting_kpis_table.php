<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDateColumnInSettingKpisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('setting_kpis', function (Blueprint $table) {
            $table->date("date")->after("id");
            $table->date("date_from")->nullable()->change();
            $table->date("date_to")->nullable()->change();
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
            $table->dropColumn("date");
        });
    }
}
