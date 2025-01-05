<?php

use App\Models\Product;

test('Can create new product', function () {
    $response = $this->post('/api/products', [
        'name' => 'Test Product',
        'description' => 'This is a test product',
        'price' => 9.99,
        'quantity' => 10,
    ]);

    $response->assertStatus(201);
});


test("can create new product with factory", function () {
    $product = Product::factory()->create();

    $response = $this->get('/api/products');

    $response->assertStatus(200);
    $product = $product->refresh();

    $response->assertJsonFragment([
        'id' => $product->id,
    ]);
});
