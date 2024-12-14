<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CodeMaster;
use Illuminate\Support\Facades\Hash;

class CreateCodeMastersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $code_masters = [
            [
               'type'=>'COUNTRY',
               'type_code'=>'01',
               'type_name'=>'UAE',
               'type_description'=>'United Arab Emirates',
               'status'=>1,
            ],
            [
                'type'=>'COUNTRY',
                'type_code'=>'02',
                'type_name'=>'SAUDI ARABIA',
                'type_description'=>'Saudi Arabia',
                'status'=>1,
             ],
             [
                'type'=>'COUNTRY',
                'type_code'=>'03',
                'type_name'=>'HUNGARY',
                'type_description'=>'Hungary',
                'status'=>1,
             ],
             [
                'type'=>'COUNTRY',
                'type_code'=>'04',
                'type_name'=>'ITALY',
                'type_description'=>'Italy',
                'status'=>1,
             ],
             [
                'type'=>'COUNTRY',
                'type_code'=>'05',
                'type_name'=>'POLAND',
                'type_description'=>'Poland',
                'status'=>1,
             ],
             [
                'type'=>'COUNTRY',
                'type_code'=>'06',
                'type_name'=>'SARBIA',
                'type_description'=>'Serbia',
                'status'=>1,
             ],
            [
                'type'=>'COUNTRY',
                'type_code'=>'07',
                'type_name'=>'JAPAN',
                'type_description'=>'Japan',
                'status'=>1,
            ],
            [
                'type'=>'RL',
                'type_code'=>'01',
                'type_name'=>'Niloy International Ltd. RL - 525',
                'type_description'=>'Soinik Club, Banani, Dhaka.',
                'status'=>1,
            ],
            [
                'type'=>'RL',
                'type_code'=>'02',
                'type_name'=>'South Breeze Corporation Ltd. RL - 1255',
                'type_description'=>'Sikder Plaza, Soinik Club, Dhaka.',
                'status'=>1,
            ],
            [
                'type'=>'RL',
                'type_code'=>'03',
                'type_name'=>'Molla International. RL - 1043',
                'type_description'=>'Block # C, Banani, Dhaka.',
                'status'=>1,
            ],
            [
                'type'=>'RL',
                'type_code'=>'04',
                'type_name'=>'Al Taiyob International Limited - RL 1603',
                'type_description'=>'Purana Paltan.',
                'status'=>1,
            ],
            [
                'type'=>'TRADE',
                'type_code'=>'01',
                'type_name'=>'Office facilites cleaner',
                'type_description'=>'Office facilites cleaner',
                'status'=>1,
            ],
            [
                'type'=>'TRADE',
                'type_code'=>'02',
                'type_name'=>'Load unload worker',
                'type_description'=>'Load unload worker',
                'status'=>1,
            ],
        ];

        foreach ($code_masters as $key => $code_master_data) {
            CodeMaster::create($code_master_data);
        }
    }
}
