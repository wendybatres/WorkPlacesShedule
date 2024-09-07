<?php

use Database\Seeders\CategorySeeder;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\LoginPage;
use App\Models\User;

test('Fail Login', function () {
    $this->browse(function (Browser $browser) {
        $user = User::factory()->create([
            'password' => "testroot",
            'role' => User::ADMIN
        ]);

        $response = $browser->visit('/')
            ->type('email', $user->email)
            ->type('password', 'testroot2')
            ->press('Login');

        $response->assertSee('These credentials do not match our records.');
    });
});

test('Login with page', function () {
    $this->browse(function (Browser $browser) {
        $user = User::factory()->create([
            'password' => "testroot",
            'role' => User::ADMIN
        ]);

        $response = $browser->visit(new LoginPage)
            ->type('@email', $user->email)
            ->type('@password', 'testroot')
            ->press("Login");
        
        $response->userAuthenticated();
    });
});

test('Create product', function () {
    $this->browse(function (Browser $browser) {
        $user = User::factory()->create([
            'password' => "testroot",
            'role' => User::ADMIN
        ]);

        $browser->loginAs($user);

        $browser->visit('/home')
            ->clickLink("+ Product")
            ->type('name', "Producto test")
            ->type('description', "Producto test")
            ->type('price', 100);

        $browser->attach('image', __DIR__ . '/photo1719344135.jpeg');

        $browser->press('Crear producto');
    });
});
