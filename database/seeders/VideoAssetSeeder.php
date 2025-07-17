<?php

namespace Database\Seeders;

use App\Models\VideoAsset;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VideoAssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VideoAsset::factory()->count(3)->create();
    }
}
