<?php

namespace Database\Seeders;

use App\Models\Enumerate;
use App\Models\EnumerateItem;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EnumerateItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
            ['taiwan', '台灣', 'TW', 'TWN', '158', 1, true],
            ['hongkong', '香港', 'HK', 'HKG', '344', 2, false],
            ['china', '中國', 'CN', 'CHN', '156', 3, false],
        ];

        foreach($countries as $country)
        {
            $enumerateItem = new EnumerateItem();
            $enumerateItem->name = $country[0];
            $enumerateItem->title = $country[1];
            $enumerateItem->value = $country[2];
            $enumerateItem->value_alt = $country[3];
            $enumerateItem->value_alt_2 = $country[4];
            $enumerateItem->sequence = $country[5];
            $enumerateItem->is_enabled = $country[6];
            $enumerateItem->enumerate_id = Enumerate::where('name', 'country_codes')->first()->id;
            $enumerateItem->save();
        }
        
        $filename = 'country';
        $path = storage_path() . "/json/${filename}.json";
        $json = json_decode(file_get_contents($path), true);

        $countryCallingCodeEnumerate = Enumerate::where('name', 'country_calling_codes')->first();
        $countryCallingCodeCount = 1;
        foreach ($json['userinfo_country_code'] as $key => $value)
        {
            if ($key == 0) continue;
            $countryCallingCode = new EnumerateItem();
            $countryCallingCode->name = $key;
            $countryCallingCode->title = $value;
            $countryCallingCode->value = $json['id_to_countrycode'][$key];
            $countryCallingCode->value_alt = $key;
            $countryCallingCode->sequence = $countryCallingCodeCount ++;
            $countryCallingCode->is_enabled = true;
            $countryCallingCode->enumerate_id = $countryCallingCodeEnumerate->id;
            $countryCallingCode->save();
        }


        $filename = 'taiwan-zip-code';
        $path = storage_path() . "/json/${filename}.json";
        $json = json_decode(file_get_contents($path), true);

        $cityEnumerate = Enumerate::where('name', 'cities')->first();
        $districtEnumerate = Enumerate::where('name', 'region')->first();
        $countDistricts = 1;
        foreach($json['cities'] as $key => $value)
        {
            $city = new EnumerateItem();
            $city->name = $value['name'];
            $city->title = $value['name'];
            $city->value = $value['name'];
            $city->value_alt = $value['code'];
            $city->sequence = $key + 1;
            $city->is_enabled = true;
            $city->enumerate_id = $cityEnumerate->id;
            $city->save();

            foreach($value['region'] as $k => $region)
            {
                $district = new EnumerateItem();
                $district->name = $region['name'];
                $district->title = $region['name'];
                $district->value = $region['name'];
                $district->value_alt = $region['code'];
                $district->value_alt_2 = $city->name;
                $district->sequence = $countDistricts ++;
                $district->is_enabled = true;
                $district->enumerate_id = $districtEnumerate->id;
                $district->save();
            }
        }
    }
}
