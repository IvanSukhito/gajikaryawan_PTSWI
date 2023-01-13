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
        Schema::create('history_lembur', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('karyawan_id')->default(0);
            $table->datetime('att_start')->nullable();
            $table->datetime('att_end')->nullable();
            $table->integer('lama_lembur')->default(0);
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
        Schema::dropIfExists('history_lembur');
    }
};
