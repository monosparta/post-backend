<?php

namespace Database\Seeders;

use App\Models\Enumerate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EnumerateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $enumerate = new Enumerate();
        $enumerate->name = 'country_codes';
        $enumerate->title = '國碼';
        $enumerate->description = 'ISO 3166-1 國家代碼（二位代碼）';
        $enumerate->default_value = 'TW';
        $enumerate->is_enabled = true;
        $enumerate->save();

        $enumerate = new Enumerate();
        $enumerate->name = 'country_calling_codes';
        $enumerate->title = '國際電話區號';
        $enumerate->description = 'ITU-T E.123 and E.164 標準國際電話區號';
        $enumerate->default_value = '+886';
        $enumerate->is_enabled = true;
        $enumerate->save();

        $enumerate = new Enumerate();
        $enumerate->name = 'cities';
        $enumerate->title = '城市';
        $enumerate->description = '台灣縣市';
        $enumerate->default_value = '台中市';
        $enumerate->is_enabled = true;
        $enumerate->save();

        $enumerate = new Enumerate();
        $enumerate->name = 'region';
        $enumerate->title = '鄉鎮區';
        $enumerate->description = '台灣鄉鎮區';
        $enumerate->default_value = '西區';
        $enumerate->is_enabled = true;
        $enumerate->save();
    }
}
