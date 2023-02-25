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
        Schema::create('karyawan_karir', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('karyawans_id')->default(0);
            $table->string('kode_basic_salary')->nullable();
            $table->string('kode_tunjangan')->nullable();
            $table->decimal('basic_salary',26, 2)->nullable();
            $table->decimal('tunj_jabatan', 26, 2)->nullable();
            $table->decimal('tunj_shift',26, 2)->nullable();
            $table->decimal('tunj_kerajinan',26, 2)->nullable();
            $table->decimal('tunj_kehadiran',26, 2)->nullable();
            $table->decimal('tunj_transport',26,2)->nullable();
            $table->decimal('tunj_bonus_produksi',26,2)->nullable();
            $table->decimal('jk',3,2)->nullable();
            $table->decimal('jkk',3,2)->nullable();
            $table->decimal('jht',3,2)->nullable();
            $table->decimal('jp',3,2)->nullable();
            $table->decimal('jm',3,2)->nullable();
            $table->decimal('akdhk',3,2)->nullable();
            $table->decimal('igd',3,2)->nullable();
            $table->decimal('spn',3,2)->nullable();
            $table->decimal('jht_epl',3,2)->nullable();
            $table->decimal('jp_epl',3,2)->nullable();
            $table->decimal('jm_epl',3,2)->nullable();
            $table->string('kode_ptkp')->nullable();
            $table->decimal('ptkp',26,2)->nullable();
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
        Schema::dropIfExists('karyawan_tunjangan');
    }
};
