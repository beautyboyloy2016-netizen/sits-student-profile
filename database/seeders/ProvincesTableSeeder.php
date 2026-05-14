<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProvincesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('provinces')->delete();
        
        \DB::table('provinces')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => '1',
                'name_kh' => 'បន្ទាយមានជ័យ',
                'name_en' => 'Banteay Meanchey',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'code' => '2',
                'name_kh' => 'បាត់ដំបង',
                'name_en' => 'Battambang',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'code' => '3',
                'name_kh' => 'កំពង់ចាម',
                'name_en' => 'Kampong Cham',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'code' => '4',
                'name_kh' => 'កំពង់ឆ្នាំង',
                'name_en' => 'Kampong Chhnang',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'code' => '5',
                'name_kh' => 'កំពង់ស្ពឺ',
                'name_en' => 'Kampong Speu',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'code' => '6',
                'name_kh' => 'កំពង់ធំ',
                'name_en' => 'Kampong Thom',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'code' => '7',
                'name_kh' => 'កំពត',
                'name_en' => 'Kampot',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'code' => '8',
                'name_kh' => 'កណ្ដាល',
                'name_en' => 'Kandal',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'code' => '9',
                'name_kh' => 'កោះកុង',
                'name_en' => 'Koh Kong',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'code' => '10',
                'name_kh' => 'ក្រចេះ',
                'name_en' => 'Kratie',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'code' => '11',
                'name_kh' => 'មណ្ឌលគិរី',
                'name_en' => 'Mondul Kiri',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'code' => '12',
                'name_kh' => 'រាជធានីភ្នំពេញ',
                'name_en' => 'Phnom Penh',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'code' => '13',
                'name_kh' => 'ព្រះវិហារ',
                'name_en' => 'Preah Vihear',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'code' => '14',
                'name_kh' => 'ព្រៃវែង	',
                'name_en' => 'Prey Veng',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'code' => '15',
                'name_kh' => 'ពោធិ៍សាត់	',
                'name_en' => 'Pursat',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'code' => '16',
                'name_kh' => 'រតនគិរី	',
                'name_en' => 'Ratanak Kiri',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'code' => '17',
                'name_kh' => 'សៀមរាប	',
                'name_en' => 'Siemreap',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'code' => '18',
                'name_kh' => 'ព្រះសីហនុ	',
                'name_en' => 'Preah Sihanouk',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            18 => 
            array (
                'id' => 19,
                'code' => '19',
                'name_kh' => 'ស្ទឹងត្រែង	',
                'name_en' => 'Stung Treng',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            19 => 
            array (
                'id' => 20,
                'code' => '20',
                'name_kh' => 'ស្វាយរៀង	',
                'name_en' => 'Svay Rieng',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            20 => 
            array (
                'id' => 21,
                'code' => '21',
                'name_kh' => 'តាកែវ	',
                'name_en' => 'Takeo',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            21 => 
            array (
                'id' => 22,
                'code' => '22',
                'name_kh' => 'ឧត្ដរមានជ័យ	',
                'name_en' => 'Oddar Meanchey',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            22 => 
            array (
                'id' => 23,
                'code' => '23',
                'name_kh' => 'កែប	',
                'name_en' => 'Kep',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            23 => 
            array (
                'id' => 24,
                'code' => '24',
                'name_kh' => 'ប៉ៃលិន	',
                'name_en' => 'Pailin',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            24 => 
            array (
                'id' => 25,
                'code' => '25',
                'name_kh' => 'ត្បូងឃ្មុំ	',
                'name_en' => 'Tboung Khmum',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}