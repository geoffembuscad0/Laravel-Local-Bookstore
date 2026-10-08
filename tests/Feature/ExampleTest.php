<?php

it('returns a successful response', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

it('does not allow a regular user to access the admin area', function () {
    $user = \App\Models\User::factory()->create();
    $user->assignRole(\Spatie\Permission\Models\Role::findOrCreate('User'));

    $this->actingAs($user)
        ->get('/admin/books')
        ->assertForbidden();
});

it('allows an admin to access the admin books page', function () {
    $admin = \App\Models\User::factory()->create();
    $admin->assignRole(\Spatie\Permission\Models\Role::findOrCreate('Admin'));

    $this->actingAs($admin)
        ->get('/admin/books')
        ->assertOk();
});
