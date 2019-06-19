<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function guests_may_not_create_threads()
    {
        $this->withoutExceptionHandling();
        $this->expectException(AuthenticationException::class);
        $thread = factory(Thread::class)->make();
        $this->post('/threads', $thread->toArray());
    }

    /** @test */
    function an_authenticated_user_can_create_new_forum_threads()
    {
        $this->actingAs($user = factory(User::class)->create());
        $thread = factory(Thread::class)->make();
        $this->post('/threads', $thread->toArray());

        $this->get($thread->path())
             ->assertSee($thread->title)
             ->assertSee($thread->body);
    }
}
