<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use App\Notifications\OrderPlaced;
use Database\Factories\DatabaseNotificationFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class NotificationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_see_all_notifications()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $unreadNotification = DatabaseNotificationFactory::new()->create();
        $readNotification = DatabaseNotificationFactory::new()->create(['read_at' => now()]);

        $this->assertCount(2, $admin->notifications);

        $this
            ->get(route('admin.notifications.index'))
            ->assertSee($unreadNotification->data['message'])
            ->assertSee($readNotification->data['message']);
    }

    public function test_admin_can_read_notification()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $notification = DatabaseNotificationFactory::new()->create();

        $this->assertCount(1, $admin->unreadNotifications);

        $this
            ->get(route('admin.notifications.show', $notification->id))
            ->assertRedirect($notification->data['link']);

        $this->assertCount(0, $admin->fresh()->unreadNotifications);
    }

    // public function test_admin_can_filter_unread_notifications_only()
    // {
    //     $admin = User::factory()->create(['role' => 'admin']);
    //     $this->actingAs($admin);

    //     $unreadNotification = DatabaseNotificationFactory::new()->create();
    //     $readNotification = DatabaseNotificationFactory::new()->create([
    //         'data' => ['message' => 'This is read message', 'link' => 'This is link'],
    //         'read_at' => now()
    //     ]);

    //     $this
    //         ->get(route('admin.unread-notifications'))
    //         ->assertSee($unreadNotification->data['message'])
    //         ->assertDontSee($readNotification->data['message']);
    // }

    // public function test_unauthorized_user_cannot_see_admin_notifications()
    // {
    //     $admin = User::factory()->create(['role' => 'admin']);
    //     $notification = DatabaseNotificationFactory::new()->create(['notifiable_id' => $admin->id]);

    //     $this
    //         ->get(route('admin.notifications.index'))
    //         ->assertRedirect(route('login'));
    //     $this
    //         ->get(route('admin.notifications.show' , $notification->id))
    //         ->assertRedirect(route('login'));
    //     $this
    //         ->get(route('admin.unread-notifications'))
    //         ->assertRedirect(route('login'));

    //     $this->actingAs($admin);

    //     $this
    //         ->get(route('admin.notifications.index'))
    //         ->assertSuccessful();
    //     $this
    //         ->get(route('admin.notifications.show' , $notification->id))
    //         ->assertRedirect($notification->data['link']);
    //     $this
    //         ->get(route('admin.unread-notifications'))
    //         ->assertSuccessful();
    // }
}
