<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Helpers\Helper;
use App\Models\Product;
use App\Models\OrderDetail;
use App\Services\CheckoutServices;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CheckOutTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Undocumented function
     *
     * @return void
     */
    public function test_checkout_cart_empty()
    {
        $response = $this->get('/checkout1');
        $response->assertRedirect('products');
        $response->assertStatus(302);
    }
    /**
     * Feature test checkout a client anonymous
     *
     * @return void
     */
    public function test_checkout_uno_cliente_anonymous()
    {
        //Product::factory()->count(5); //no work with sqlite
        Helper::create_a_product_manually();
        $product = Product::first();
        $response = $this->post('/cart', [
            "product_id" => $product->id
        ])->assertRedirect(route('cart'));

        $response = $this->get('/checkout1');
        $response->assertViewIs("checkout.checkout"); // view checkout
        $response->assertSee("Contact Information"); //view contain the word
        $response->assertSee("Checkout"); // view contain the word
        $this->assertEquals($product->price, $product->price); // compare price firts prduct
        $response->assertViewHas("items"); // variable in the view
        $response->assertStatus(200);
    }
    /**
     * Feature test checkout data all null
     *
     * @return void
     */
    public function test_checkout_data_null()
    {
        $response = $this->post('/checkout2', [])
            ->assertSessionHasErrors([
                'user_id' => 'The user id field is required.',
                'user_name' => 'The user name field is required.',
                'user_mobile' => 'The user mobile field is required.',
                'user_email' => 'The user email field is required.',
            ]);
    }
    /**
     * Feature test checkout data user_id null
     *
     * @return void
     */
    public function test_checkout_data_user_id_null()
    {
        $response = $this->post('/checkout2', [
            'user_name' => 'Joshua',
            'user_mobile' => '9612386248',
            'user_email' => 'usermail@gmail.com'
        ])->assertSessionHasErrors([
            'user_id' => 'The user id field is required.'
        ]);
    }
    /**
     * Feature test checkout data user_name null
     *
     * @return void
     */
    public function test_checkout_data_user_name_null()
    {
        $response = $this->post('/checkout2', [
            'user_id' => 0,
            'user_mobile' => '9612386248',
            'user_email' => 'usermail@gmail.com'
        ])->assertSessionHasErrors([
            'user_name' => 'The user name field is required.',
        ]);
    }
    /**
     * Feature test checkout data user_mobile null
     *
     * @return void
     */
    public function test_checkout_data_user_mobile_null()
    {
        $response = $this->post('/checkout2', [
            'user_id' => 0,
            'user_name' => 'Joshua',
            'user_email' => 'usermail@gmail.com'
        ])->assertSessionHasErrors([
            'user_mobile' => 'The user mobile field is required.',
        ]);
    }
    /**
     * Feature test checkout data user_email null
     *
     * @return void
     */
    public function test_checkout_data_user_email_null()
    {
        $response = $this->post('/checkout2', [
            'user_id' => 0,
            'user_name' => 'Joshua',
            'user_mobile' => '9612386248',
        ])->assertSessionHasErrors([
            'user_email' => 'The user email field is required.',
        ]);
    }
    /**
     * feature verify with codebuy exists in order
     *
     * @return void
     */
    public function test_verify_codebuy_exists_in_order_not_repeat_in_new_order()
    {
        Helper::create_user_anonymous();
        Order::create([
            'user_id' => 0,
            'codebuy' => 'J7J7J7J7J6J6J5J5J4J3',
            'customer_name' => 'Joshua',
            'customer_email' => 'email@gmail.com',
            'customer_mobile' => '9612386248',
            'cant' => 0,
            'total' => 0,
            'user_address_id' => 0
        ]);
        $response = CheckoutServices::verifyCodebuyNotExistsInAnOrder('J7J7J7J7J6J6J5J5J4J3');
        $this->assertFalse($response);
    }
    /**
     * Undocumented function
     *
     * @return void
     */
    public function test_verify_method_codebuy_not_exist_in_order()
    {
        $response = CheckoutServices::verifyCodebuyNotExistsInAnOrder('J7J7J7J7J6J6J5J5J4J1');
        $this->assertTrue($response);
    }
}
