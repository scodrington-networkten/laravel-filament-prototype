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
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('uid')->unique();
            $table->string('type');
            $table->string('section_id')->nullable();
            $table->string('section_name')->nullable();
            $table->string('web_title');
            $table->string('web_url');
            $table->string('image_url_large')->nullable();
            $table->string('image_url')->nullable();
            $table->text('bio')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
