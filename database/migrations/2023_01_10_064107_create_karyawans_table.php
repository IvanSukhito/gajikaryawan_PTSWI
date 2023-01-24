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
            $table->string('nama');
            $table->string('nik');
            $table->string('jenis_kelamin')->nullable();
            $table->string('no_ktp')->nullable();
            $table->string('no_npwp')->nullable();
            $table->string('no_kpj')->nullable();
            $table->date('tgl_mulai_kerja')->nullable();
            $table->date('tgl_keluar_kerja')->nullable();
            $table->string('title_plan')->nullable();
            $table->integer('supervisor_no')->default(0);
            $table->date('tgl_lahir')->nullable();
            $table->string('tempat_lahir')->nullable();
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
            $table->string('nama_bank')->nullable();
            $table->string('no_rekening')->nullable();
            $table->string('fas_kesehatan')->nullable();
            $table->tinyInteger('status')->default(1);
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

