<?php

namespace Tests\Unit;

use App\Thread;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->thread = factory(Thread::class)->create();
    }

    /** @test */
    function a_thread_can_make_a_string_path()
    {
        $thread = create(Thread::class);
        $this->assertEquals("/threads/{$thread->channel->slug}/{$thread->id}", $thread->path());
    }

    /** @test */
    function a_thread_can_have_replies()
    {
        $this->assertInstanceOf(Collection::class, $this->thread->replies);
    }

    /** @test */
    function a_thread_has_a_creator()
    {
        $thread = factory(Thread::class)->create();
        $this->assertInstanceOf(User::class, $this->thread->creator);
    }

    /** @test */
    function a_thread_can_add_a_reply()
    {
        $this->thread->addReply([
            'body'    => 'foobar',
            'user_id' => '1'
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    /** @test */
    function a_thread_belongs_to_a_channel()
    {
        $thread = create(Thread::class);
        $this->assertInstanceOf('App\Channel', $thread->channel);
    }
}
