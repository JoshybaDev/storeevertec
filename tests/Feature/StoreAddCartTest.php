<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Helpers\Helper;
use App\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreAddCartTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Feature test show empty cart
     *
     * @return void
     */
    public function test_show_cart_empty()
    {
        $response = $this->get('/cart');
        $response->assertViewIs("cart.cart");// view cart
        $response->assertSee("Cart");// view contain the word
        $response->assertViewHas("items");// variable in the view
        $response->assertSee("Your cart is empty! Sounds like a good time to"); //Vista contiene la palabra
        $response->assertStatus(200);
    }

    public function test_add_product_your_cart()
    {
        //Product::factory()->count(5); //no work with sqlite
        Helper::create_a_product_manually();
        $product=Product::first();
        $this->post('cart',[
            "product_id"=>$product->id
        ])->assertRedirect(route('cart'));

        $response = $this->get('/cart');
        $response->assertViewIs("cart.cart");// view cart
        $response->assertViewHas("items");// variable in the view
        $response->assertViewHas("total");// variable in the view
        $response->assertSee($product->name);// view contain the product name
        $this->assertEquals("products/$product->id","products/$product->id");// view contain url show product
        $response->assertStatus(200);
    }
    public function test_add_product_invalid_your_cart()
    {
        $response = $this->post('/cart',[
            "product_id"=>500
        ])->assertRedirect('cart')
        ->assertSessionHasErrors([
            'product_id' => 'The selected product id is invalid.',
        ]);
    }
    public function test_add_product_id_null_your_cart()
    {
        $response = $this->post('/cart')->assertRedirect('cart')
        ->assertSessionHasErrors([
            'product_id' => 'The product id field is required.',
        ]);
    }    

}

