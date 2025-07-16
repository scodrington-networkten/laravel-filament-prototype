<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;
use App\Models\Tag;
use Illuminate\Support\Facades\Storage;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = Storage::get('sample-tags.json');
        $data = json_decode($json, true);

        if (!$data) {
            $this->command->info("could not find sample-tags.json");
        }

        //find all tags in the article
        foreach ($data as $tagData) {
            $uid        = $tagData['id'];
            $articleUid = $tagData['articleUid'];

            //find the corresponding tag, if not create it
            $tagModel = Tag::where('uid', $uid)->first();
            if (!$tagModel) {
                $tagModel = Tag::factory()->create([
                    'uid'             => $tagData['id'],
                    'type'            => $tagData['type'],
                    'section_id'      => $tagData['sectionId'] ?? null,
                    'section_name'    => $tagData['sectionName'] ?? null,
                    'web_title'       => $tagData['webTitle'],
                    'web_url'         => $tagData['webUrl'],
                    'image_url'       => $tagData['bylineImageUrl'] ?? null,
                    'image_url_large' => $tagData['bylineLargeImageUrl'] ?? null,
                    'bio'             => $tagData['bio'] ?? null,
                    'first_name'      => $tagData['firstName'] ?? null,
                    'last_name'       => $tagData['lastName'] ?? null,
                ]);
            }

            //find the associated article
            $articleModel = Article::where('uid', $articleUid)->first();

            //if article deosnt have that tag attached, attach it
            if (!$articleModel->tags()->where('tag_id', $tagModel->id)->exists()) {
                $articleModel->tags()->attach($tagModel->id);
            }
        }
    }
}
