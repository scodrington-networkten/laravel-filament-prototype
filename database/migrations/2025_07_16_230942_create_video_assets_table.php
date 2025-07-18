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
        Schema::create('video_assets', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // Primary tab fields
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->bigInteger('media_available_date')->nullable();  // timestamp stored as int
            $table->bigInteger('media_expiration_date')->nullable();
            $table->uuid('guid')->unique()->nullable(false);

            // Secondary tab
            $table->boolean('pl_media_approved')->default(false);

            // TV Data tab
            $table->string('tv_channel')->nullable();
            $table->string('tv_episode')->nullable();
            $table->string('tv_season')->nullable();
            $table->string('tv_show')->nullable();
            $table->string('tv_show_group')->nullable();
            $table->integer('tv_week')->nullable();

            // Extras tab
            $table->bigInteger('broadcast_date_previous')->nullable();
            $table->string('production_company')->nullable();
            $table->string('production_country')->nullable();
            $table->string('program_classification')->nullable();
            $table->string('program_language')->nullable();
            $table->boolean('restriction_by_member')->default(false);
            $table->string('clip_category')->nullable();
            $table->string('consumer_advice')->nullable();
            $table->string('content_security')->nullable();
            $table->integer('dmi_show_id')->nullable();
            $table->integer('series_crid')->nullable();
            $table->boolean('shoppable_enabled')->default(false);
            $table->string('video_format_type')->nullable();
            $table->integer('pl_media_pid')->nullable();

            // JSON / complex fields
            $table->json('media_ratings')->nullable();
            $table->json('pl_media_chapters')->nullable();
            $table->json('video_segments')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_assets');
    }
};
