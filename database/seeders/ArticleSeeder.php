<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = Storage::disk('public')->get('sample-data.json');
        $data = json_decode($json, true);

        if (!$data) {
            $this->command->info("could not find sample data.json");
        }

        $articles = $data['records'];
        foreach ($articles as $article) {
            Article::create([
                'uid'                => $article['id'],
                'type'               => $article['type'],
                'title'              => $article['fields']['headline'],
                'subtitle'           => $article['fields']['trailText'] ?? null,
                'body'               => $article['fields']['body'],
                'last_modified_date' => $article['fields']['lastModified'],
                'published_date'     => $article['webPublicationDate'],
                'publication'        => $article['fields']['publication'],
                'publication_url'    => $article['webUrl'],
                'byline'             => $article['fields']['byline'] ?? null,
                'pillar'             => $article['pillarName'],
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);
        }
    }
}
