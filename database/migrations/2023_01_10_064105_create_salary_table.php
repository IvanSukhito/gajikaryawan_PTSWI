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
        Schema::create('salary', function (Blueprint $table) {
            $table->id();
            $table->string('grade_series')->nullable();
            $table->decimal('basic_salary', 26, 2)->nullable();
            $table->decimal('tunjangan_jabatan', 26, 2)->nullable();
            $table->decimal('tunjangan_kerajinan', 26, 2)->nullable();
            $table->decimal('tunjangan_shift', 26, 2)->nullable();
            $table->decimal('tunjangan_kehadiran', 26, 2)->nullable();
            $table->decimal('slt_day', 26, 2)->nullable();
            $table->decimal('bonus_produksi', 26, 2)->nullable();
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
        Schema::dropIfExists('salaray');
    }
};
