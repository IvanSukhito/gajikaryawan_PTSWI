<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BPJSSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     

        DB::table('BPJS')->insertGetId([
            'code' => 'JK',
            'score' => '0.4',
            'unit' => '%',
            'paid_employee' => 0,
            'paid_company' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

 
        DB::table('BPJS')->insertGetId([
            'code' => 'JKK',
            'score' => '0.89',
            'unit' => '%',
            'paid_employee' => 0,
            'paid_company' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('BPJS')->insertGetId([
            'code' => 'JHT',
            'score' => '3.70',
            'unit' => '%',
            'paid_employee' => 0,
            'paid_company' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('BPJS')->insertGetId([
            'code' => 'JP',
            'score' => '2',
            'unit' => '%',
            'paid_employee' => 0,
            'paid_company' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('BPJS')->insertGetId([
            'code' => 'JM',
            'score' => '4',
            'unit' => '%',
            'paid_employee' => 0,
            'paid_company' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('BPJS')->insertGetId([
            'code' => 'AKDHK',
            'score' => '0.24',
            'unit' => '%',
            'paid_employee' => 0,
            'paid_company' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('BPJS')->insertGetId([
            'code' => 'IGD',
            'score' => '1.50',
            'unit' => '%',
            'paid_employee' => 0,
            'paid_company' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('BPJS')->insertGetId([
            'code' => 'SPN',
            'score' => '0.50',
            'unit' => '%',
            'paid_employee' => 0,
            'paid_company' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('BPJS')->insertGetId([
            'code' => 'JHT',
            'score' => '2',
            'unit' => '%',
            'paid_employee' => 1,
            'paid_company' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('BPJS')->insertGetId([
            'code' => 'JP',
            'score' => '1',
            'unit' => '%',
            'paid_employee' => 1,
            'paid_company' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('BPJS')->insertGetId([
            'code' => 'JM',
            'score' => '1',
            'unit' => '%',
            'paid_employee' => 1,
            'paid_company' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
