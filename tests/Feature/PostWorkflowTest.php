<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_loads(): void
    {
        $response = $this->get('/');

        $response->assertOk();
    }

    public function test_author_can_create_published_post(): void
    {
        $author = User::factory()->create(['role' => 'author']);

        $response = $this
            ->actingAs($author)
            ->post(route('posts.store'), [
                'title' => 'My First Post',
                'body' => 'Simple body',
            ]);

        $post = Post::first();

        $response->assertRedirect(route('posts.edit', $post));
        $this->assertSame('my-first-post', $post->slug);
        $this->assertSame(1, $post->active);
    }

    public function test_duplicate_titles_are_rejected(): void
    {
        $author = User::factory()->create(['role' => 'author']);
        Post::factory()->for($author, 'author')->create([
            'title' => 'Same Title',
            'slug' => 'same-title',
        ]);

        $this->actingAs($author)
            ->followingRedirects()
            ->post(route('posts.store'), [
                'title' => 'Same Title',
                'body' => 'Another body',
            ])
            ->assertSeeText('This title has already been taken.');

        $this->assertSame(1, Post::count());
    }

    public function test_post_body_is_sanitized_on_create_and_render(): void
    {
        $author = User::factory()->create(['role' => 'author']);

        $this->actingAs($author)->post(route('posts.store'), [
            'title' => 'Xss Check',
            'body' => '<script>alert(1)</script><b>Hello</b>',
        ]);

        $post = Post::firstOrFail();
        $this->assertSame('alert(1)Hello', $post->body);

        $this->get(route('post', $post))
            ->assertOk()
            ->assertSeeText('alert(1)Hello')
            ->assertDontSee('<script>');
    }

    public function test_subscriber_cannot_create_post(): void
    {
        $subscriber = User::factory()->subscriber()->create();

        $this->actingAs($subscriber)
            ->post(route('posts.store'), [
                'title' => 'Blocked',
                'body' => 'No access',
            ])
            ->assertForbidden();
    }

    public function test_post_validation_requires_title_and_body(): void
    {
        $author = User::factory()->create(['role' => 'author']);

        $this->actingAs($author)
            ->post(route('posts.store'), [
                'title' => '',
                'body' => '',
            ])
            ->assertSessionHasErrors(['title', 'body']);
    }

    public function test_user_cannot_edit_or_delete_foreign_post(): void
    {
        $owner = User::factory()->create(['role' => 'author']);
        $other = User::factory()->create(['role' => 'author']);
        $post = Post::factory()->for($owner, 'author')->create();

        $this->actingAs($other)->put(route('posts.update', $post), [
            'title' => 'Changed',
            'body' => 'Changed',
        ])->assertForbidden();

        $this->actingAs($other)->delete(route('posts.destroy', $post))
            ->assertForbidden();
    }

    public function test_author_can_delete_own_post_via_delete_route(): void
    {
        $author = User::factory()->create(['role' => 'author']);
        $post = Post::factory()->for($author, 'author')->create();

        $this->actingAs($author)->delete(route('posts.destroy', $post))
            ->assertRedirect('/');

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
        $this->get('/delete/'.$post->id)->assertNotFound();
    }

    public function test_comment_is_validated_and_sanitized(): void
    {
        $author = User::factory()->create(['role' => 'author']);
        $commenter = User::factory()->create(['role' => 'author']);
        $post = Post::factory()->for($author, 'author')->create();

        $this->actingAs($commenter)
            ->post(route('comments.store', $post), ['body' => ''])
            ->assertSessionHasErrors('body');

        $this->actingAs($commenter)
            ->post(route('comments.store', $post), ['body' => '<img src=x onerror=1>Great'])
            ->assertRedirect(route('post', $post));

        $comment = Comment::query()->firstOrFail();
        $this->assertSame('Great', $comment->body);
    }

    public function test_post_update_sanitizes_body_and_regenerates_slug(): void
    {
        $author = User::factory()->create(['role' => 'author']);
        $post = Post::factory()->for($author, 'author')->create([
            'title' => 'Old Title',
            'slug' => 'old-title',
            'body' => 'Old body',
        ]);

        $this->actingAs($author)
            ->put(route('posts.update', $post), [
                'title' => 'New Title',
                'body' => '<b>Fresh</b><script>alert(1)</script>',
            ])
            ->assertRedirect(route('post', $post->fresh()));

        $post->refresh();
        $this->assertSame('new-title', $post->slug);
        $this->assertSame('Freshalert(1)', $post->body);
    }
}
