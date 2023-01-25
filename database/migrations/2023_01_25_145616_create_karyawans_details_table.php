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
        Schema::create('karyawans_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('karyawans_id')->default(0);
            $table->string('title_plan')->nullable();
            $table->tinyInteger('usia')->default(1);
            $table->string('agama');
            $table->string('level_pendidikan')->nullable();
            $table->integer('berat_badan')->default(0);
            $table->integer('tinggi_badan')->default(0);
            $table->text('alamat_sementara')->nullable();
            $table->string('kode_pos1')->nullable();
            $table->text('alamat_tetap')->nullable();
            $table->string('kode_pos2')->nullable();
            $table->string('negara')->nullable();
            $table->string('telephone_1')->nullable();
            $table->string('telephone_2')->nullable();  
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
        Schema::dropIfExists('karyawans_details');
    }
};
