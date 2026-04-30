<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $postsTable = config('stellar-cms.tables.posts', 'stellar_posts');
        $commentsTable = config('stellar-cms.tables.comments', 'stellar_comments');

        Schema::create($commentsTable, function (Blueprint $table) use ($postsTable): void {
            $table->id();
            $table->foreignId('on_post')
                ->constrained($postsTable)
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('from_user')
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->text('body');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        $commentsTable = config('stellar-cms.tables.comments', 'stellar_comments');

        Schema::dropIfExists($commentsTable);
    }
};

