<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Media;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;

/**
 * Class MediaSeeder
 * Populates media for given articles
 */
class MediaSeeder extends Seeder
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
            $elements = $article['elements'] ?? null;

            //find the associated article in the DB (connecting sample data to real db data)
            $dbArticle = Article::where('title', $article['webTitle'])->first();
            if (!$dbArticle) {
                $this->command->warn("A corresponding article could not be found, this media could not be created");
                continue;
            }

            //assess each element (finding the image types)
            foreach ($elements as $element) {
                $elementType = $element['type'] ?? null;
                if ($elementType !== 'image')
                    continue;

                //extract assets (the image data)
                $assets = $element['assets'] ?? null;
                if (empty($assets))
                    continue;

                //build up each media item and create it
                foreach ($assets as $asset) {
                    $relation = $element['relation'] ?? null;
                    $type     = $element['type'] ?? null;
                    $mimeType = $asset['mimeType'] ?? null;
                    $url      = $asset['file'] ?? null;

                    $typeData = Arr::get($asset, 'typeData', []);

                    $metadata = [
                        'alt_text'   => Arr::get($typeData, 'altText'),
                        'caption'    => Arr::get($typeData, 'caption'),
                        'credit'     => Arr::get($typeData, 'credit'),
                        'source'     => Arr::get($typeData, 'source'),
                        'width'      => Arr::get($typeData, 'width') ? (int)$typeData['width'] : null,
                        'height'     => Arr::get($typeData, 'height') ? (int)$typeData['height'] : null,
                        'image_type' => Arr::get($typeData, 'imageType'),
                    ];

                    Media::create([
                        'article_id' => $dbArticle->id,
                        'relation'   => $relation,
                        'type'       => $type,
                        'mime_type'  => $mimeType,
                        'url'        => $url,
                        'metadata'   => json_encode($metadata),
                    ]);
                }
            }
        }
    }
}
