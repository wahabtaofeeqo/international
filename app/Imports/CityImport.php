<?php

namespace App\Imports;

use App\Models\City;
use App\Models\Country;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithProgressBar;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class CityImport implements ToModel, WithHeadingRow, WithBatchInserts {

    use Importable, SkipsFailures, SkipsErrors;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row) {

        $city = $row['city'];
        $country = $row['country'];

        $latitude = 0;
        $longitude = 0;

        $country = Country::firstOrCreate(array('name' => $row['country']), array('phone_index' => '000'));
        $check = City::where('name', $city)->first();

        if (empty($check)) {
            
            return new City([
                'name' => $city,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'region_id' => 0,
                'country_id' => $country->id]);
        }

        return null;
    }

    public function batchSize(): int {
        return 1000;
    }
}