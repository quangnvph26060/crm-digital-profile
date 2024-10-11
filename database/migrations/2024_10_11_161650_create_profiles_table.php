<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('config_id');
            $table->string('ma_muc_luc');
            $table->string('hop_so');
            $table->string('ho_so_so');
            $table->string('tieu_de_ho_so');
            $table->date('ngay_bat_dau');
            $table->date('ngay_ket_thuc');
            $table->integer('so_to');
            $table->string('thbq');
            $table->string('ghi_chu');
            $table->timestamps();

            $table->foreign('config_id')->references('id')->on('configs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropForeign(['config_id']);
        });
        
        Schema::dropIfExists('profiles');
    }
}
