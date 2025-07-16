<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use function PHPUnit\Framework\isNull;
use function Symfony\Component\String\s;

class GuardianSeedData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:guardian-seed-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //fetch article records from the search endpoint
        $this->createSampleArticleData();

        //fetch data about tags (extracted from articles as they belong to articles)
        $this->createSampleTagData();

        //fetch data about sections
        $this->createSampleSectionData();
    }

    private function createSampleArticleData(): null|array
    {
        $articles     = [];
        $requestCount = 2;
        for ($i = 0; $i < $requestCount; $i++) {
            $response = Http::get('http://content.guardianapis.com/search', [
                'api-key'       => env('GUARDIAN_API_KEY'),
                'page-size'     => 50,
                'show-fields'   => 'all',
                'show-tags'     => 'all',
                'show-elements' => 'all',
                'page'          => $i + 1
            ]);

            if ($response->failed()) {
                $this->error('failed to fetch data from the API');
                return null;
            }

            $data = $response->json();
            foreach ($data['response']['results'] as $article) {
                $articles[] = $article;
            }
        }

        $articleCount = count((array)$articles);
        $this->line("Retrieved {$articleCount} of articles from the API");

        $sampleArticleData = Storage::put('sample-articles.json', json_encode($articles, JSON_PRETTY_PRINT));
        if (!$sampleArticleData) {
            $this->error('failed to save sample-articles.json to storage');
        }
        $this->line('sample-articles.json has been stored in storage/app');

        return $articles;
    }

    private function createSampleTagData(): null|array
    {
        if (!Storage::exists('sample-articles.json')) {
            $this->error('Expected to find sample-articles.json in storage but could not be round');
            return null;
        }

        $articleSampleData = json_decode(Storage::get('sample-articles.json'));

        $tags = [];
        foreach ($articleSampleData as $article) {
            foreach ($article->tags as $tag) {
                $tag->articleUid = $article->id;
                $tags[] = $tag;
            }
        }

        $tagsSampleData = Storage::put('sample-tags.json', json_encode($tags, JSON_PRETTY_PRINT));
        if (!$tagsSampleData) {
            $this->error('Failed to store tags in sample sample-tags.json');
        }
        $this->line('sample-tags.json has been stored in storage/app');

        return $tags;
    }

    private function createSampleSectionData(): null|array
    {
        $response = Http::get('http://content.guardianapis.com/sections', [
            'api-key' => env('GUARDIAN_API_KEY')
        ]);

        if ($response->failed()) {
            $this->error('failed to fetch data from the API');
            return null;
        }

        $data     = $response->json();
        $sections = [];
        foreach ($data['response']['results'] as $section) {
            $sections[] = $section;
        }

        $sectionsSampleData = Storage::put('sample-sections.json', json_encode($sections, JSON_PRETTY_PRINT));
        if (!$sectionsSampleData) {
            $this->error('Failed to store sections in sample sample-sections.json');
        }
        $this->line('sample-sections.json has been stored in storage/app');

        return $sections;
    }
}
