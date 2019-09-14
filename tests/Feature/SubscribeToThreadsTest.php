<?php

namespace Tests\Unit;

use App\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Route;

class SubscribeToThreadsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_user_can_subscribe_to_threads()
    {

        $this->signIn();

        $thread = create(Thread::class);

        $this->post($thread->path() . '/subscriptions');

        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'Some Reply here'
        ]);


    }
}