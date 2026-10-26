<?php

namespace Tests\Feature;

use App\Models\Akun;
use Tests\TestCase;

class UserLoanDetailTest extends TestCase
{
    public function test_loan_detail_requires_authentication(): void
    {
        $this->get(route('user.status.show', 'PJM-TEST-0001'))
            ->assertRedirect(route('login'));
    }

    public function test_non_student_accounts_cannot_access_student_loan_details(): void
    {
        $admin = new Akun(['role' => 'admin_sarana']);

        $this->actingAs($admin)
            ->get(route('user.status.show', 'PJM-TEST-0001'))
            ->assertForbidden();
    }
}
