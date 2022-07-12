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

        $this->get(route('admin.notifications.index'))
            ->assertSee($unreadNotification->data['message'])
            ->assertSee($readNotification->data['message']);
    }

    public function test_admin_can_read_notification()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $notification = DatabaseNotificationFactory::new()->create();

        $this->assertCount(1, $admin->unreadNotifications);

        $this->get(route('admin.notifications.show', $notification->id))
            ->assertRedirect($notification->data['link']);

        $this->assertCount(0, $admin->fresh()->unreadNotifications);
    }

    public function test_admin_can_filter_unread_notifications_only()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $unreadNotification = DatabaseNotificationFactory::new()->create();
        $readNotification = DatabaseNotificationFactory::new()->create([
            'data' => ['message' => 'This is read message', 'link' => 'This is link'],
            'read_at' => now()
        ]);

        $this->get(route('admin.unread-notifications'))
            ->assertSee($unreadNotification->data['message'])
            ->assertDontSee($readNotification->data['message']);
    }

    public function test_unauthorized_user_cannot_see_admin_notifications()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $notification = DatabaseNotificationFactory::new()->create(['notifiable_id' => $admin->id]);

        $this->get(route('admin.notifications.index'))
            ->assertRedirect(route('login'));
        $this->get(route('admin.notifications.show' , $notification->id))
            ->assertRedirect(route('login'));
        $this->get(route('admin.unread-notifications'))
            ->assertRedirect(route('login'));

        $this->actingAs($admin);

        $this->get(route('admin.notifications.index'))
            ->assertSuccessful();
        $this->get(route('admin.notifications.show' , $notification->id))
            ->assertRedirect($notification->data['link']);
        $this->get(route('admin.unread-notifications'))
            ->assertSuccessful();
    }

//    public function test_notification_is_sent_after_order_placed()
//    {
//        Notification::fake();
//
//        $admin = User::factory()->create(['role' => 'admin']);
//        $user = User::factory()->create();
//        $order = Order::factory()->create(['user_id' => $user->id]);
//
//        $attributes = [
//            'contact_name' => 'aung htet paing',
//            'contact_email' => 'aunghtetpaing.mtkn@gmail.com',
//            'address' => 'address',
//            'city' => 'city',
//            'state' => 'state',
//            'zip_code' => '12345',
//            'amount' => '1000',
//            'payment_method_id' => 'pm_1LKcyZK3AEGA3BHpgeQkZ9Bo'
//        ];
//
//        $this->post(route('orders.store'), $attributes)
//            ->assertRedirect('/login');
//
//        $this->actingAs($user);
//
//        $this->post(route('orders.store'), $attributes)
//            ->assertSuccessful();
//        //$admin->notify(new OrderPlaced($order));
//
//        Notification::assertSentTo($admin, OrderPlaced::class);
//    }
}
