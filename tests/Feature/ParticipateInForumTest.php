<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function unauthenticated_users_may_not_add_replies()
    {
        $this->post("/threads/some-channel/1/replies", [])
             ->assertRedirect('/login');
    }

    /** @test */
    function an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->actingAs($user = create(User::class));
        $thread = create(Thread::class);
        $reply = make(Reply::class);
        $this->post($thread->path() . "/replies", $reply->toArray());

        $this->get($thread->path())
             ->assertSee($reply->body);
    }

    /** @test */
    function a_reply_requires_a_bdy()
    {
        $this->signIn();

        $thread = create(Thread::class);
        $reply = make(Reply::class, ['body' => null]);
        $this->post($thread->path() . "/replies", $reply->toArray())
             ->assertSessionHasErrors('body');
    }

    /** @test */
    function unauthenticated_users_can_not_delete_replies()
    {
        // $this->withoutExceptionHandling();
        $reply = create('App\Reply');
        $this->delete("/replies/{$reply->id}")
             ->assertRedirect("login");

        $this->signIn()
             ->delete("/replies/{$reply->id}")
             ->assertStatus(403);

    }

    /** @test */
    function authorized_user_can_delete_replies()
    {
        $this->signIn();
        $reply = create('App\Reply',['user_id' => auth()->id()]);
        $this->delete("/replies/{$reply->id}")
            ->assertStatus(302);

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }
}
