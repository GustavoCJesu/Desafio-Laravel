<?php

use App\Models\Category;
use App\Models\Epi;

test('updating an epi changes the existing record instead of creating a new one', function () {
    $category = Category::forceCreate(['name' => 'Proteção da cabeça']);
    $newCategory = Category::forceCreate(['name' => 'Proteção das mãos']);
    $epi = Epi::create([
        'name' => 'Capacete',
        'ca' => '12345',
        'category_id' => $category->id,
        'status' => 'Ativo',
    ]);

    $response = $this->actingAs(userWithPermissions('ativo', 'epis.update'))
        ->put(route('epi.update', ['epi' => $epi->id]), [
            'name' => 'Luva nitrílica',
            'ca' => '54321',
            'category_id' => $newCategory->id,
            'status' => 'Inativo',
        ]);

    $response->assertSessionHas('Success');
    expect(Epi::count())->toBe(1);
    expect($epi->fresh())
        ->name->toBe('Luva nitrílica')
        ->ca->toBe('54321')
        ->category_id->toBe($newCategory->id)
        ->status->toBe('Inativo');
});

test('showing an epi returns the requested record as json', function () {
    $category = Category::forceCreate(['name' => 'Proteção da cabeça']);
    $epi = Epi::create([
        'name' => 'Capacete',
        'ca' => '12345',
        'category_id' => $category->id,
        'status' => 'Ativo',
    ]);

    $this->actingAs(userWithPermissions('ativo', 'epis.view'))
        ->getJson(route('epi.show', ['epi' => $epi->id]))
        ->assertOk()
        ->assertJson(['id' => $epi->id, 'name' => 'Capacete']);
});
