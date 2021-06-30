<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadsTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_authenticated_user_can_create_a_thread()
    {
        $user = User::factory()->create();
        $threadTitle = 'A Test Thread';
        $threadContent = 'The content of the test thread.';

        $response = $this->actingAs($user)->post(route('threads.store'), [
            'title' => $threadTitle,
            'content' => $threadContent,
        ]);

        $response->assertRedirect(route('threads.index'));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('threads', [
            'user_id' => $user->id,
            'title' => $threadTitle,
            'content' => $threadContent,
        ]);
    }

    public function test_a_guest_user_cannot_create_a_thread()
    {
        $response = $this->post(route('threads.store'));
        $response->assertRedirect('login');
    }
}
