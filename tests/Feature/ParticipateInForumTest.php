<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function unauthenticated_users_may_not_add_replies()
    {
        $this->post( "/threads/some-channel/1/replies",[])
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
}
