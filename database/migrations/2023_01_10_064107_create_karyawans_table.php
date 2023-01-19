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
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('position_id')->default(0);
            $table->string('nama_pekerja');
            $table->string('npwp');
            $table->string('nik');
            $table->date('tgl_masuk');
            $table->string('kode')->nullable();
            $table->date('dob')->nullable();
            $table->tinyInteger('gender')->default(1);
            $table->string('no_hp')->nullable();
            $table->string('alamat');
            $table->decimal('gaji_pokok',26, 2)->nullable();
            $table->text('keterangan')->nullable();
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('karyawans');
    }
};
