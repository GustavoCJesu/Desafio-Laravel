<?php

use App\Models\User;

test('the home page sends guests to the login', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Entrar');
});

test('the home page sends authenticated users to the employees page', function () {
    $this->actingAs(User::factory()->create())
        ->get(route('home'))
        ->assertOk()
        ->assertSee('Ir para o sistema')
        ->assertSee(route('employees.index'));
});
