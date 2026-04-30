<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $postsTable = config('stellar-cms.tables.posts', 'stellar_posts');

        Schema::create($postsTable, function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->boolean('active')->default(true);
            $table->string('title')->unique();
            $table->text('body');
            $table->dateTime('published_at')->nullable();
            $table->string('slug')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        $postsTable = config('stellar-cms.tables.posts', 'stellar_posts');

        Schema::dropIfExists($postsTable);
    }
};

