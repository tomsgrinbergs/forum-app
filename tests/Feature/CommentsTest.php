<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentsTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_authenticated_user_can_add_a_comment_to_a_thread()
    {
        $user = User::factory()->create();
        $thread = Thread::factory()->create();
        $commentContent = 'The content of a test comment.';

        $response = $this->actingAs($user)->post(route('comments.store', $thread), [
            'comment' => $commentContent,
        ]);

        $response->assertRedirect(route('threads.show', $thread));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'thread_id' => $thread->id,
            'content' => $commentContent,
        ]);
    }

    public function test_a_guest_user_cannot_add_a_comment_to_a_thread()
    {
        $response = $this->post(route('comments.store', 1));
        $response->assertRedirect('login');
    }

    public function test_an_authenticated_user_can_upvote_a_comment()
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create();

        $response = $this->actingAs($user)->post(route('comments.upvote', $comment));

        $response->assertRedirect(route('threads.show', $comment->thread));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('comment_upvotes', [
            'comment_id' => $comment->id,
            'user_id' => $user->id,
        ]);
    }

    public function test_a_guest_user_cannot_upvote_a_comment()
    {
        $response = $this->post(route('comments.upvote', 1));
        $response->assertRedirect('login');
    }

    public function test_a_user_cannot_upvote_the_same_comment_again()
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create();

        // 1st Upvote
        $response = $this->actingAs($user)->post(route('comments.upvote', $comment));
        $response->assertSessionHasNoErrors();

        // 2nd Upvote
        $response = $this->actingAs($user)->post(route('comments.upvote', $comment));
        $response->assertSessionHasErrors();

        $this->assertDatabaseCount('comment_upvotes', 1);
    }
}
