<?php

use App\Models\Makanan;
use App\Models\User;

function buatUser(string $role = 'user'): User
{
    return User::factory()->create([
        'phone' => '08' . fake()->unique()->numerify('##########'),
        'role' => $role,
    ]);
}

test('halaman login bisa dibuka', function () {
    $this->get('/login')->assertOk();
});

test('user bisa login dengan nomor HP', function () {
    $user = buatUser();

    $this->post('/login', ['phone' => $user->phone, 'password' => 'password'])
        ->assertRedirect('/home');

    $this->assertAuthenticatedAs($user);
});

test('login gagal kalau password salah', function () {
    $user = buatUser();

    $this->post('/login', ['phone' => $user->phone, 'password' => 'salah'])
        ->assertSessionHasErrors('phone');

    $this->assertGuest();
});

test('admin bisa menambah makanan', function () {
    $this->actingAs(buatUser('admin'))
        ->post('/admin/makanan', [
            'name' => 'Nasi Goreng Test',
            'price' => 15000,
            'region' => 'Jawa',
        ])
        ->assertRedirect(route('admin.makanan.create'));

    expect(Makanan::where('name', 'Nasi Goreng Test')->exists())->toBeTrue();
});

test('user biasa ditolak dari halaman admin', function () {
    $this->actingAs(buatUser('user'))
        ->get('/admin/dashboard')
        ->assertForbidden();
});
