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
            $table->string('bpjs_jk')->nullable();
            $table->string('bpjs_jkk')->nullable();
            $table->string('bpjs_jht')->nullable();
            $table->string('bpjs_jp')->nullable();
            $table->string('bpjs_m')->nullable();
            $table->string('akdhk')->nullable();
            $table->string('igd')->nullable();
            $table->string('spn')->nullable();
            $table->string('jht_epl')->nullable();
            $table->string('jp_epl')->nullable();
            $table->string('jm_epl')->nullable();
            $table->string('ptkp')->nullable();

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
