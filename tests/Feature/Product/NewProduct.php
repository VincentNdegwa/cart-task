<?php

use Database\Factories\ProductFactory;

test('Can create new product', function () {
    $response = $this->post('/products', [
        'name' => 'Test Product',
        'description' => 'This is a test product',
        'price' => 9.99,
        'quantity' => 10,
    ]);

    $response->assertStatus(201);
});


test("can create new product with factory", function () {
    $product = ProductFactory::factory()->create(1);

    $response = $this->get('/products');

    $response->assertStatus(200);

    $response->assertJsonFragment([
        'name' => $product->name,
        'description' => $product->description,
        'price' => $product->price,
        'quantity' => $product->quantity,
    ]);
});
