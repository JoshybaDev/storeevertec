<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_store_products_views()
    {
        $response = $this->get('/');
        $response->assertViewIs("store.store");// Vista store
        $response->assertSee("Products"); //Vista contiene la palabra
        $product=Product::first();
        $this->assertEquals("products/".$product->id,"products/1");
        $response->assertViewHas("products"); //Variable en la vista
        $response->assertStatus(200);
    }

    public function test_store_show_product()
    {
        //$this->withoutExceptionHandling();
        $product=Product::first();
        $response = $this->get("products/".$product->id);
        $response->assertViewIs("store.show");// Vista store
        $response->assertSee("Products"); //Vista contiene la palabra
        $response->assertViewHas("product"); //Variable en la vista
        $response->assertStatus(200);
        $this->assertEquals(number_format($product->price,2),'26.00');
    }
    public function test_store_show_product_no_found()
    {
        $this->get("products/10000")
        ->assertRedirect('products')
        ->assertSessionHasErrors([
            'product_id'=>'The product no found',
        ]);
    }
}
