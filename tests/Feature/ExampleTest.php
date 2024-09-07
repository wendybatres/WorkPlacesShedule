<?php

use App\Models\Product;
use App\Models\User;
use Laravel\Socialite\Contracts\User as ProviderUser;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Mail;
use App\Mail\NoticeInvoiceCreated;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('skips test', function () {})->skip();


it('is customer', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/home');

    $response->assertStatus(200);
    $response->assertSee("Facturas");
});

it('is admin', function () {
    $user = User::factory()->create([
        'role' => User::ADMIN
    ]);

    $response = $this->actingAs($user)->get('/home');

    $response->assertStatus(200);
    $response->assertSee("+ Producto");
});

it('is creats an user', function () {
    $user = User::factory()->create();

    $this->assertEquals(1, User::count());
    $this->assertDatabaseCount(User::class, 1);
    $this->assertDatabaseHas('users', [
        'email' => $user->email
    ]);
});

it('returns ok', function () {
    $response = $this->post('/webhook');

    $response->assertStatus(200)
        ->assertJson([
            'status' => 'ok'
        ]);
});

it('Fakes product', function () {
    $mock = mock(Product::class, function ($mock) {
        $mock->shouldReceive('luis')->andReturn('hola');
    });

    $this->assertEquals('hola', $mock->luis());
});

it('Fakes GitHub', function () {
    $mock = mock(ProviderUser::class, function ($mock) {
        $mock->shouldReceive('getName')->andReturn('Fernando');
        $mock->shouldReceive('getEmail')->andReturn('fernando@codigofacilito.com');
    });

    Socialite::shouldReceive('driver->user')->andReturn($mock);

    $response = $this->get('/auth/callback');

    $response->assertRedirect('/home');
});

it('Fakes email', function () {
    Mail::fake();

    $user = User::factory()->create();

    $response = $this->get('send-mail/' . $user->id);

    Mail::assertQueued(NoticeInvoiceCreated::class);

    $response->assertStatus(200);
});

it('upload file', function () {

    Storage::fake('avatars');

    $file = UploadedFile::fake()->image('avatar.jpg');

    $this->post('/webhook', [
        'image' => $file,
    ]);

    Storage::disk('avatars')->assertExists('profile_pictures/'  . $file->hashName());
});
