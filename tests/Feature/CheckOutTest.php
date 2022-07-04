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
        Helper::create_user_anonymus();
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
    /**
     * Feature test create orden client anonymous
     *
     * @return void
     */
    public function test_checkout_dos_cliente_anonymous_emptyCart()
    {
        $this->withoutExceptionHandling();
        Helper::create_user_anonymus();
        $response = $this->post('/checkout2', [
            'user_id' => 0,
            'user_name' => 'Joshua',
            'user_mobile' => '9612386248',
            'user_email' => 'usermail@gmail.com'
        ]);
        $response->assertRedirect(route('checkout3', ['codeunique' => 'NoValidCode_EmptyProducts']));
        $response = $this->get('/checkout3/NoValidCode_EmptyProducts');
        $response->assertViewHas("codeunique"); // variable in the view
        $response->assertViewIs("checkout.address_error"); // view checkout
        $response->assertSee("NoValidCode_EmptyProducts"); // view contain the word
        $response->assertStatus(200);
    }
    /**
     * Feature test create orden client anonymous
     *
     * @return void
     */
    public function test_checkout_dos_cliente_anonymous()
    {
        $this->withoutExceptionHandling();
        Helper::create_user_anonymus();
        //StoreAddCartTest - test_add_product_your_cart()
        //Product::factory()->count(5); //no work with sqlite
        Helper::create_a_product_manually();
        $product = Product::first();
        $this->post('cart', [
            "product_id" => $product->id
        ])->assertRedirect(route('cart'));
        //Consult /cart
        $response = $this->get('/cart');
        $response->assertViewIs("cart.cart"); // view cart
        $response->assertViewHas("items"); // variable in the view
        $response->assertViewHas("total"); // variable in the view
        $response->assertSee($product->name); // view contain the product name
        $this->assertEquals("products/$product->id", "products/$product->id"); // view contain url show product
        $response->assertStatus(200);
        $response = $this->post('/checkout2', [
            'user_id' => 0,
            'user_name' => 'Joshua',
            'user_mobile' => '9612386248',
            'user_email' => 'usermail@gmail.com'
        ]);
        $nowOrder = Order::first()->orderBy('id', 'DESC')->get();
        $orderdetails = OrderDetail::Where('order_id', '=', $nowOrder[0]['id'])->get();
        $response->assertRedirect(route('checkout3', ['codeunique' => $nowOrder[0]['codebuy']]));
        //Consult /checkout3
        $response = $this->get('/checkout3' . "/" . $nowOrder[0]['codebuy']);
        $response->assertViewIs("checkout.address"); // view checkout
        $response->assertSee("Shipping address"); //view contain the word
        $response->assertSee("SUMMARY"); // view contain the word
        $this->assertEquals($orderdetails[0]["name"], $orderdetails[0]["name"]); // compare price firts prduct
        $response->assertViewHas("items"); // variable in the view
        $response->assertStatus(200);
    }
    /**
     * Feature verify checkout3 codebuy is invalid
     * Get
     * Capture your address
     *
     * @return void
     */
    public function test_code_unique_in_checkout_tres_invalid()
    {
        $response = $this->get('/checkout3' . "/" . 'CodigoNoExisteInSystem12561')
            ->assertSessionHasErrors([
                'codeunique' => 'Your Code is Invalid!!',
            ]);
    }
}
