<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_notification_is_prepared_when_a_subscribed_thread_receives_a_new_reply_that_is_not_by_the_current_user()
    {

        $this->signIn();

        $thread = create(Thread::class)->subscribe();

        $this->assertCount(0, auth()->user()->notifications);

        $thread->addReply([
            'user_id' => auth()->id(),
            'body'    => 'Some Reply here'
        ]);

        $this->assertCount(0, auth()->user()->fresh()->notifications);

        $thread->addReply([
            'user_id' => create(User::class)->id,
            'body'    => 'Some Reply here'
        ]);

        $this->assertCount(1, auth()->user()->fresh()->notifications);
    }

    /** @test */
    function a_user_can_mark_a_notification_as_read()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $thread = create(Thread::class)->subscribe();


        $thread->addReply([
            'user_id' => create(User::class)->id,
            'body'    => 'Some Reply here'
        ]);

        $user = auth()->user();

        $this->assertCount(1, $user->unreadNotifications);

        $notificationId = $user->unreadNotifications->first()->id;

        $this->delete("/profiles/{$user->name}/notifications/{$notificationId}");

        $this->assertCount(0, $user->fresh()->unreadNotifications);
    }

    /** @test */
    function a_user_can_fetch_their_unread_notifications()
    {
        $this->signIn();

        $thread = create(Thread::class)->subscribe();


        $thread->addReply([
            'user_id' => create(User::class)->id,
            'body'    => 'Some Reply here'
        ]);

        $user = auth()->user();

        $response = $this->getJson("/profiles/{$user->name}/notifications/")
            ->json();
        $this->assertCount(1, $response);

    }
}
