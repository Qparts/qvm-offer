<?php

namespace Database\Seeders;

use App\Models\OfferType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfferTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OfferType::updateOrCreate(['name' => 'special offers', 'en_name' => 'special offers']);

    }
}
