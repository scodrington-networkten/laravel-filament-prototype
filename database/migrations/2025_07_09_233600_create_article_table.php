<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('type');
            $table->string('title'); //fields->headline
            $table->text('subtitle')->nullable(); //fields->trailText
            $table->text('body');
            $table->timestamp('last_modified_date')->nullable(); //fields->lastModified
            $table->timestamp('published_date'); //webPublicationDate
            $table->string('publication')->nullable();
            $table->string('publication_url')->nullable(); //webUrl
            $table->string('byline')->nullable();
            $table->string('pillar')->nullable(); //pillarName

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
