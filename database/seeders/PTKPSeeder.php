<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PTKPSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     

        DB::table('ptkp')->insertGetId([
            'code' => 'TK/0',
            'amount' => '54000000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('ptkp')->insertGetId([
            'code' => 'TK/1',
            'amount' => '58500000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('ptkp')->insertGetId([
            'code' => 'TK/2',
            'amount' => '63000000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('ptkp')->insertGetId([
            'code' => 'TK/3',
            'amount' => '67500000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('ptkp')->insertGetId([
            'code' => 'K/0',
            'amount' => '58500000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('ptkp')->insertGetId([
            'code' => 'K/1',
            'amount' => '63000000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('ptkp')->insertGetId([
            'code' => 'K/2',
            'amount' => '67500000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('ptkp')->insertGetId([
            'code' => 'K/3',
            'amount' => '72000000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

    }
}
