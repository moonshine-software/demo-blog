<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use MoonShine\Models\MoonshineUser;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('articles', static function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('author_id')
                ->nullable()
                ->constrained('moonshine_users')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->string('slug');
            $table->text('description');
            $table->text('thumbnail')
                ->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
