<?php

namespace Tests\Feature;

use App\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_user_can_view_all_threads()
    {
        $thread = factory(Thread::class)->create();
        $response = $this->get('/threads');
        $response->assertStatus(200);
        $response->assertSee($thread->title);

    }

    /** @test */
    function a_user_can_read_a_single_thread()
    {
        $thread = factory(Thread::class)->create();

        $response = $this->get('/threads/'. $thread->id);
        $response->assertSee($thread->title);
    }


}
