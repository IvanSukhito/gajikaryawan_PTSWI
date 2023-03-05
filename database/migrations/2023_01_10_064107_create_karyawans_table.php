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
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id();
            $table->string("company");
            $table->string('nama');
            $table->string('nik');
            $table->string('kartu_no');
            $table->string('dept');
            $table->string('jenis_kelamin')->nullable();
            $table->string('no_ktp')->nullable();
            $table->string('no_npwp')->nullable();
            $table->string('no_kpj')->nullable();
            $table->date('tgl_mulai_kerja')->nullable();
            $table->integer('supervisor_no')->default(0);
            $table->integer('lama_kerja')->default(0);
            $table->date('tgl_lahir')->nullable();
            $table->string('tempat_lahir')->nullable();         
            $table->string('nama_bank')->nullable();
            $table->string('no_rekening')->nullable();
            $table->string('fas_kesehatan')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('karir')->default(0);
            $table->timestamps();
                // $table->tinyInteger('gender')->default(1);
            // $table->string('npwp');
            // $table->string('nik');
            // $table->date('tgl_masuk');
            // $table->string('kode')->nullable();
            // $table->date('dob')->nullable();
            // $table->tinyInteger('gender')->default(1);
            // $table->string('no_hp')->nullable();
            // $table->string('alamat');
            // $table->decimal('gaji_pokok',26, 2)->nullable();
            // $table->text('keterangan')->nullable();
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

