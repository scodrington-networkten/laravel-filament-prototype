<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Media;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

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

            //assess each element (finding the image types)
            foreach ($elements as $element) {
                $elementType = $element['type'] ?? null;
                if ($elementType !== 'image')
                    continue;

                //extract assets (the image data)
                $assets = $element['assets'] ?? null;
                if (count($assets) == 0)
                    continue;

                //find the associated article in the DB (connecting sample data to real db data)
                $dbArticle = Article::where('title', $article['webTitle'])->first();

                //build up each media item
                foreach ($assets as $asset) {
                    $relation = $element['relation'] ?? null;
                    $type     = $element['type'] ?? null;
                    $mimeType = $asset['mimeType'] ?? null;
                    $url      = $asset['file'] ?? null;

                    $typeData = $asset['typeData'] ?? null;

                    $metadata               = [];
                    $metadata['alt_text']   = isset($typeData['altText']) ? (string)$typeData['altText'] : null;
                    $metadata['caption']    = isset($typeData['caption']) ? (string)$typeData['caption'] : null;
                    $metadata['credit']     = isset($typeData['credit']) ? (string)$typeData['credit'] : null;
                    $metadata['source']     = isset($typeData['source']) ? (string)$typeData['source'] : null;
                    $metadata['width']      = isset($typeData['width']) ? (int)$typeData['width'] : null;
                    $metadata['height']     = isset($typeData['height']) ? (int)$typeData['height'] : null;
                    $metadata['image_type'] = isset($typeData['imageType']) ? (string)$typeData['imageType'] : null;

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
