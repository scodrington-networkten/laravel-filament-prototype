<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = Storage::disk('public')->get('sections-data.json');
        $data = json_decode($json, true);

        if (!$data) {
            $this->command->info("could not find sample sections-data.json");
        }

        $sections = $data['records'];
        foreach ($sections as $section) {
            Section::factory()->create([
                'uid'       => $section['id'],
                'web_title' => $section['webTitle'],
                'web_url'   => $section['webUrl'],
                'editions'  => $section['editions']
            ]);
        }
    }
}
