<?php

namespace Tests\Feature\Controller;

use App\Role;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RolesTest extends TestCase
{
    use DatabaseMigrations;

    public  function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->nonAdminUser = factory(User::class)->create();

        $this->role = factory(Role::class)->create();
    }

    /** @test */
    public function non_admin_cannot_see_all_roles()
    {
        $response = $this->actingAs($this->nonAdminUser)->get('/admin/roles');
        $response->assertStatus(403);
    }

    /** @test */
    public function admin_can_see_all_roles()
    {
        $adminUser = $this->createUserWithPermissionTo('do:admin:actions');

        $respone = $this->actingAs($adminUser)->get('/admin/roles');
        $respone->assertStatus(200);
        $respone->assertSee('Roles');
    }

    /** @test */
    public function non_admin_cannot_see_one_role()
    {
        $response = $this->actingAs($this->nonAdminUser)->get('/admin/roles/' . $this->role->id);
        $response->assertStatus(403);
        $response->assertSee('You do not have permission to see this page');
    }

    /** @test */
    public function admin_can_see_one_role()
    {
        $adminUser = $this->createUserWithPermissionTo('do:admin:actions');

        $respone = $this->actingAs($adminUser)->get('/admin/roles/' . $this->role->id);
        $respone->assertStatus(200);
        $respone->assertSee($this->role->name);
    }

    /** @test */
    public function non_admin_cannot_see_create_page()
    {
        $response = $this->actingAs($this->nonAdminUser)->get('/admin/roles/create');
        $response->assertStatus(403);
    }

    /** @test */
    public function non_admin_can_see_create_page()
    {
        $adminUser = $this->createUserWithPermissionTo('do:admin:actions');

        $respone = $this->actingAs($adminUser)->get('/admin/roles/create');
        $respone->assertStatus(200);
        $respone->assertSee('Roles');
    }

    /** @test */
    public function admin_can_create_role()
    {
        $roleName = 'My Testing Role';

        $adminUser = $this->createUserWithPermissionTo('do:admin:actions');

        $response = $this->actingAs($adminUser)->withSession(['_token' => 'test'])->post('/admin/roles', [
            'name' =>  $roleName,
            'label' => 'Test role',
            '_token' => 'test'
        ]);
        $response->assertRedirect('/admin/roles');
        $response->assertDontSee('You do not have permission to see this page');

        // Check if role has been created in database
        $role = Role::where('name', $roleName)->first();
        $this->assertEquals($roleName, $role->name);
    }

    /** @test */
    public function non_admin_can_not_create_role()
    {
        $roleName = 'My Testing Role';

        $response = $this->actingAs($this->nonAdminUser)->withSession(['_token' => 'test'])->post('/admin/roles', [
            'name' =>  $roleName,
            'label' => 'Test role',
            '_token' => 'test'
        ]);
        $response->assertStatus(403);
        $response->assertSee('You do not have permission to see this page');
    }
}
