<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Aaran\Assets\Features\Customise::hasBlog()) {

            Schema::create('blog_likes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('blog_post_id')->references('id')->on('blog_posts');
                $table->tinyInteger('like')->default(0);
                $table->timestamps();
            });

        }
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_likes');
    }
};
