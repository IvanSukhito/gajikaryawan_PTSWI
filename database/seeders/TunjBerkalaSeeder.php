<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TunjBerkalaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     

        DB::table('tj_berkala')->insertGetId([
            'code' => '0',
            'amount' => '0',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('tj_berkala')->insertGetId([
            'code' => '1',
            'amount' => '5000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('tj_berkala')->insertGetId([
            'code' => '2',
            'amount' => '11000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('tj_berkala')->insertGetId([
            'code' => '3',
            'amount' => '14000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('tj_berkala')->insertGetId([
            'code' => '4',
            'amount' => '18000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('tj_berkala')->insertGetId([
            'code' => '5',
            'amount' => '21000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('tj_berkala')->insertGetId([
            'code' => '6',
            'amount' => '24000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('tj_berkala')->insertGetId([
            'code' => '7',
            'amount' => '27000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('tj_berkala')->insertGetId([
            'code' => '8',
            'amount' => '30000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('tj_berkala')->insertGetId([
            'code' => '9',
            'amount' => '33000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('tj_berkala')->insertGetId([
            'code' => '10',
            'amount' => '36000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('tj_berkala')->insertGetId([
            'code' => '11',
            'amount' => '39000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('tj_berkala')->insertGetId([
            'code' => '12',
            'amount' => '42000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('tj_berkala')->insertGetId([
            'code' => '13',
            'amount' => '45000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('tj_berkala')->insertGetId([
            'code' => '14',
            'amount' => '48000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('tj_berkala')->insertGetId([
            'code' => '15',
            'amount' => '51000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('tj_berkala')->insertGetId([
            'code' => '16',
            'amount' => '54000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('tj_berkala')->insertGetId([
            'code' => '17',
            'amount' => '57000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('tj_berkala')->insertGetId([
            'code' => '18',
            'amount' => '60000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('tj_berkala')->insertGetId([
            'code' => '19',
            'amount' => '63000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('tj_berkala')->insertGetId([
            'code' => '20',
            'amount' => '63000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('tj_berkala')->insertGetId([
            'code' => '21',
            'amount' => '6000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        for ($i =22; $i <= 45; $i++ ){

            DB::table('tj_berkala')->insertGetId([
                'code' => $i,
                'amount' => '69000',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
    
        }










     
    }
}
