<?php

namespace Tests\Feature\Controller;

use App\Profile;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->nonAdminUser = factory(User::class)->create();
    }

    /** @test */
    public function non_admin_cannot_see_all_users()
    {
        $response = $this->actingAs($this->nonAdminUser)->get('/admin/users');
        $response->assertStatus(403);
    }

    /** @test */
    public function admin_can_see_all_users()
    {
        $adminUser = $this->createUserWithPermissionTo('do:admin:actions');

        $respone = $this->actingAs($adminUser)->get('/admin/users');
        $respone->assertStatus(200);
        $respone->assertSee('Users');
    }

    /** @test */
    public function non_admin_cannot_see_one_users()
    {
        $response = $this->actingAs($this->nonAdminUser)->get('/admin/users/' . $this->nonAdminUser->id);
        $response->assertStatus(403);
    }

    /** @test */
    public function admin_can_see_one_users()
    {
        $adminUser = $this->createUserWithPermissionTo('do:admin:actions');

        $respone = $this->actingAs($adminUser)->get('/admin/users/' . $this->nonAdminUser->id);
        $respone->assertStatus(200);
        $respone->assertSee($this->nonAdminUser->name);
    }

    /** @test */
    public function logged_in_user_can_see_dashboard()
    {
        factory(Profile::class)->create(['user_id' => $this->nonAdminUser]);

        $response = $this->actingAs($this->nonAdminUser)->get('/dashboard');
        $response->assertStatus(200);
    }

    /** @test */
    public function logged_out_user_can_not_see_dashboard_and_is_redirected_to_login()
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }
}