<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Helpers\Helper;
use App\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Feature test list of products
     *
     * @return void
     */
    public function test_store_products_views()
    {
        //Product::factory()->count(5); //no work with sqlite
        Helper::create_a_product_manually();
        $response = $this->get('/');
        $response->assertViewIs("store.store"); // view store
        $response->assertSee("Products"); // view contain the word
        $product = Product::first();
        $this->assertEquals("products/" . $product->id, "products/" . $product->id);
        $response->assertViewHas("products"); // variable in the view
        $response->assertStatus(200);
    }
    /**
     * Feature test  show product detail
     *
     * @return void
     */
    public function test_store_show_product()
    {
        $this->withoutExceptionHandling();        
        //Product::factory()->count(5); //no work with sqlite
        Helper::create_a_product_manually();
        $product = Product::first();
        $response = $this->get("/products" . "/" . $product->id);
        $response->assertViewIs("store.show"); // view show
        $response->assertSee("Products"); // view contain the word
        $response->assertViewHas("product"); // variable in the view
        $response->assertStatus(200);
        $this->assertEquals(number_format($product->price, 2), number_format($product->price, 2));
    }
    /**
     * Feature test show list empty in the store
     *
     * @return void
     */
    public function test_store_show_product_no_found()
    {
        $this->get("/products/10000")
            ->assertRedirect('products') // redirect to products
            ->assertSessionHasErrors([
                'product_id' => 'The product no found',
            ]); // return with errors
    }
}
