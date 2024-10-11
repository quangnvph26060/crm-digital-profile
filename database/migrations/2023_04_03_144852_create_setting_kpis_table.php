<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingKpisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_kpis', function (Blueprint $table) {
            $table->id();
            $table->integer("week")->nullable();
            $table->date("date_from");
            $table->date("date_to");
            $table->integer("month")->nullable();
            $table->integer("year")->nullable();
            $table->integer("user_id");
            $table->integer("post_new_num");
            $table->integer("post_edit_num");
            $table->integer("post_publish_num");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('setting_kpis');
    }
}
