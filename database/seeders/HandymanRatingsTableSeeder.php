<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class HandymanRatingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('handyman_ratings')->delete();
    }
}