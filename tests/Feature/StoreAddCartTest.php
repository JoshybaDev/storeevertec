<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreAddCartTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_show_cart_empty()
    {

        $response = $this->get('/cart');
        $response->assertViewIs("cart.cart");// Vista cart
        $response->assertSee("Cart"); //Vista contiene la palabra
        $response->assertViewHas("items"); //Variable en la vista
        $response->assertSee("Your cart is empty! Sounds like a good time to"); //Vista contiene la palabra
        $response->assertStatus(200);
    }

    public function test_add_product_your_cart()
    {
        $product=Product::first();
        $this->post('cart',[
            "product_id"=>$product->id
        ])->assertRedirect(route('cart'));

        $response = $this->get('/cart');
        $response->assertViewIs("cart.cart");// Vista cart
        $response->assertViewHas("items"); //Variable en la vista
        $response->assertViewHas("total"); //Variable en la vista
        $response->assertSee($product->name);//Vista contiene el nombre
        $response->assertStatus(200);
    }
    public function test_add_product_invalid_your_cart()
    {
        $response = $this->post('cart',[
            "product_id"=>500
        ])->assertRedirect('cart')
        ->assertSessionHasErrors([
            'product_id' => 'The selected product id is invalid.',
        ]);
    }
    public function test_add_product_id_null_your_cart()
    {
        $response = $this->post('cart')->assertRedirect('cart')
        ->assertSessionHasErrors([
            'product_id' => 'The product id field is required.',
        ]);
    }    

}

