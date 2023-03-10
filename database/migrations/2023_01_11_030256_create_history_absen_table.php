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
        Schema::create('history_absen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('karyawan_id')->default(0);
            $table->string('hari')->nullable();
            $table->date('tanggal')->nullable();
            $table->char('status', 2)->default(1);
            $table->tinyInteger('weekday')->default(0);
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
        Schema::dropIfExists('history_absen');
    }
};
