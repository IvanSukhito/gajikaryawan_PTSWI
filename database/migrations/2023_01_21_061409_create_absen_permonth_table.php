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
        Schema::create('absen_permonth', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('karyawan_id')->default(0);
            $table->string('Month')->nullable();
            $table->string('Year')->nullable();
            $table->tinyInteger('H')->default(0);
            $table->tinyInteger('N')->default(0);
            $table->tinyInteger('CT')->default(0);
            $table->tinyInteger('SD')->default(0);
            $table->tinyInteger('CH')->default(0);
            $table->tinyInteger('IR')->default(0);
            $table->tinyInteger('A')->default(0);
            $table->tinyInteger('I')->default(0);
            $table->tinyInteger('S')->default(0);
            $table->tinyInteger('HD')->default(0);
            $table->tinyInteger('DL')->default(0);
            $table->tinyInteger('TL')->default(0);
            $table->tinyInteger('PC')->default(0);
            $table->tinyInteger('LC')->default(0);
            $table->tinyInteger('Deduction_1')->default(0);
            $table->tinyInteger('Deduction_2')->default(0);
            $table->tinyInteger('Working_days')->default(0);
            $table->tinyInteger('Full_Att')->default(0);
            $table->integer('Bonus')->default(0);
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
        Schema::dropIfExists('absen_permonth');
    }
};
