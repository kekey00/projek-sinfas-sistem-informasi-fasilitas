<?php

namespace Tests\Feature;

use Tests\TestCase;

class AdminNotificationsTest extends TestCase
{
    public function test_notification_center_requires_authentication(): void
    {
        $this->get(route('admin.notifications.index'))
            ->assertRedirect(route('login'));
    }
}
