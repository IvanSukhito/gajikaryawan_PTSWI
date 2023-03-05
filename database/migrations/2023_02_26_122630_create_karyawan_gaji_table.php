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
        Schema::create('karyawan_gaji', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('karyawans_id')->default(0);
            $table->string('periode_tanggal')->nullable();
            //$table->string('phase')->nullable();
            $table->string('phase_nm')->nullable();
           // $table->string('batch')->nullable();
            $table->decimal('hire_date',3,2)->nullable();
            $table->string('branch_no')->nullable();
            $table->string('branch_nm')->nullable();
            $table->decimal('basic_salary',26, 2)->nullable();
            $table->decimal('tunj_berkala', 26, 2)->nullable();
            $table->decimal('tunj_jabatan', 26, 2)->nullable();
            $table->decimal('tunj_shift',26, 2)->nullable();
            $table->decimal('tunj_kerajinan',26, 2)->nullable();
            $table->decimal('tunj_kehadiran',26, 2)->nullable();
            $table->decimal('tunj_transport',26,2)->nullable();
            $table->decimal('tunj_bonus_produksi',26,2)->nullable();
            $table->decimal('jk',26,2)->nullable();
            $table->decimal('jkk',26,2)->nullable();
            $table->decimal('jht',26,2)->nullable();
            $table->decimal('jp',26,2)->nullable();
            $table->decimal('jm',26,2)->nullable();
            $table->decimal('akdhk',26,2)->nullable();
            $table->decimal('igd',26,2)->nullable();
            $table->decimal('spn',26,2)->nullable();
            $table->decimal('jht_epl',26,2)->nullable();
            $table->decimal('jp_epl',26,2)->nullable();
            $table->decimal('jm_epl',26,2)->nullable();
            $table->decimal('upah',26,2)->nullable();
            $table->decimal('non_upah',26,2)->nullable();
            $table->decimal('lembur',26,2)->nullable();
            $table->decimal('thr_tahun',26,2)->nullable();
            $table->decimal('bonus_tahun',26,2)->nullable();
            $table->decimal('total_gaji_setahun',26,2)->nullable();
            $table->decimal('potongan_bijab',26,2)->nullable();
            $table->decimal('potongan_jp',26,2)->nullable();
            $table->decimal('potongan_jht',26,2)->nullable();
            $table->decimal('total_ptkp',26,2)->nullable();
            $table->decimal('ptkp',26,2)->nullable();
            $table->decimal('net_pkp',26,2)->nullable();
            $table->decimal('pph_21',26,2)->nullable();
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
        Schema::dropIfExists('karyawan_gaji');
    }
};
