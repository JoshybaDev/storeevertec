<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Order;
use App\Helpers\Helper;
use App\Models\Product;
use App\Models\OrderDetail;
use App\Models\OrderPackage;
use App\Models\OrderPayData;
use App\Services\PayProcessService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CheckOutShowTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_code_unique_in_checkout_show_invalid()
    {
        $response = $this->get('/checkoutshow' . "/" . 'CodigoNoExisteInSystem12561')
            ->assertRedirect(route('products'))
            ->assertSessionHasErrors([
                'codeunique' => 'Your Code is Invalid!!',
            ]);
    }
    /**
     * Feature verify that if the shipping address is not captured, redirects to checkout3
     *
     * @return void
     */
    public function test_checkout_show_order_no_delivery_address()
    {
        $this->withoutExceptionHandling();
        Helper::create_user_anonymous();
        Helper::create_a_package_manually();
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
            'user_surname' => 'Kalel',
            'user_mobile' => '9612386248',
            'user_email' => 'usermail@gmail.com'
        ]);
        $nowOrder = Order::first()->orderBy('id', 'DESC')->get();
        //$orderdetails = OrderDetail::Where('order_id', '=', $nowOrder[0]['id'])->get();
        $response->assertRedirect(route('checkout3', ['codeunique' => $nowOrder[0]['codebuy']]));
        //Verify retorne a checkout 3
        $response = $this->get("/checkoutshow" . "/" . $nowOrder[0]['codebuy'])
            ->assertRedirect(route('checkout3', ['codeunique' => $nowOrder[0]['codebuy']]));
    }
    /**
     * Feature verify that if the shipping packages is not captured, redirects to checkout5
     *
     * @return void
     */
    public function test_checkout_show_order_no_packages()
    {
        $this->withoutExceptionHandling();
        Helper::create_user_anonymous();
        Helper::create_a_package_manually();
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
            'user_surname' => 'Kalel',
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
        //Capture information of client anonymous
        $response = $this->post('/checkout4', [
            'codeunique' => $nowOrder[0]['codebuy'],
            'user_id' => 0,
            'street' => 'calle 5 de febrero',
            'city' => 'Chiapa de Corzo',
            'state' => 'Chiapas',
            'zipcode' => '29160'
        ])->assertRedirect(route('checkout5', ['codeunique' => $nowOrder[0]['codebuy']]));
        //Verify retorne a checkout 3
        $response = $this->get("/checkoutshow" . "/" . $nowOrder[0]['codebuy'])
            ->assertRedirect(route('checkout5', ['codeunique' => $nowOrder[0]['codebuy']]));
    }
    /**
     * Feature verify that 
     * shipping address is captured
     * shipping packages captured, redirects to checkout7
     *
     * @return void
     */
    public function test_checkout_show_order_no_payed()
    {
        $this->withoutExceptionHandling();
        Helper::create_user_anonymous();
        Helper::create_a_package_manually();
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
            'user_surname' => 'Kalel',
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
        //Capture information of client anonymous
        $response = $this->post('/checkout4', [
            'codeunique' => $nowOrder[0]['codebuy'],
            'user_id' => 0,
            'street' => 'calle 5 de febrero',
            'city' => 'Chiapa de Corzo',
            'state' => 'Chiapas',
            'zipcode' => '29160'
        ])->assertRedirect(route('checkout5', ['codeunique' => $nowOrder[0]['codebuy']]));
        //shipping address
        $response = $this->get('/checkout5' . "/" . $nowOrder[0]['codebuy']);
        $response->assertViewIs("checkout.shipping"); // view checkout
        $response->assertSee("Choose shipping method"); //view contain the word
        $response->assertSee("SUMMARY"); // view contain the word
        $this->assertEquals($orderdetails[0]["name"], $orderdetails[0]["name"]); // compare price firts prduct
        $response->assertViewHas("items"); // variable in the view
        $response->assertStatus(200);
        //save package
        $response = $this->post('/checkout6', [
            'codeunique' => $nowOrder[0]['codebuy'],
            'user_id' => 0,
            'package_id' => 1,
        ])->assertRedirect(route('checkout7', ['codeunique' => $nowOrder[0]['codebuy']]));
        //Verify retorne a checkout 3
        $response = $this->get("/checkoutshow" . "/" . $nowOrder[0]['codebuy'])
            ->assertRedirect(route('checkout7', ['codeunique' => $nowOrder[0]['codebuy']]));
    }
    /**
     * Feature call page for paying
     *
     * @return void
     */
    public function test_checkout7_for_paying_null_params()
    {
        //$this->withoutExceptionHandling();
        Helper::create_user_anonymous();
        Helper::create_a_package_manually();
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
            'user_surname' => 'Kalel',
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
        //Capture information of client anonymous
        $response = $this->post('/checkout4', [
            'codeunique' => $nowOrder[0]['codebuy'],
            'user_id' => 0,
            'street' => 'calle 5 de febrero',
            'city' => 'Chiapa de Corzo',
            'state' => 'Chiapas',
            'zipcode' => '29160'
        ])->assertRedirect(route('checkout5', ['codeunique' => $nowOrder[0]['codebuy']]));
        //shipping address
        $response = $this->get('/checkout5' . "/" . $nowOrder[0]['codebuy']);
        $response->assertViewIs("checkout.shipping"); // view checkout
        $response->assertSee("Choose shipping method"); //view contain the word
        $response->assertSee("SUMMARY"); // view contain the word
        $this->assertEquals($orderdetails[0]["name"], $orderdetails[0]["name"]); // compare price firts prduct
        $response->assertViewHas("items"); // variable in the view
        $response->assertStatus(200);
        //save package
        $response = $this->post('/checkout6', [
            'codeunique' => $nowOrder[0]['codebuy'],
            'user_id' => 0,
            'package_id' => 1,
        ])->assertRedirect(route('checkout7', ['codeunique' => $nowOrder[0]['codebuy']]));
        $response = $this->get('/checkout7' . "/" . $nowOrder[0]['codebuy']);
        $response->assertViewIs("checkout.paynow"); // view checkout
        $response->assertSee("Pay"); //view contain the word
        $response->assertSee("Order Summary"); // view contain the word
        $this->assertEquals($orderdetails[0]["name"], $orderdetails[0]["name"]); // compare price firts prduct
        $response->assertViewHas("items"); // variable in the view
        $response->assertStatus(200);        
        //verify errors
        $response = $this->post('/startProcessPay', [])
            ->assertRedirect(route('checkout7', ['codeunique' => $nowOrder[0]['codebuy']]))
            ->assertSessionHasErrors([
                'codeunique' => 'The codeunique field is required.',
                'user_id' => 'The user id field is required.'
            ]);
    }
    /**
     * Feature call page for paying
     *
     * @return void
     */
    public function test_checkout7_redirect_url_for_paying()
    {
        $this->withoutExceptionHandling();
        Helper::create_user_anonymous();
        Helper::create_a_package_manually();
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
            'user_surname' => 'Kalel',
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
        //Capture information of client anonymous
        $response = $this->post('/checkout4', [
            'codeunique' => $nowOrder[0]['codebuy'],
            'user_id' => 0,
            'street' => 'calle 5 de febrero',
            'city' => 'Chiapa de Corzo',
            'state' => 'Chiapas',
            'zipcode' => '29160'
        ])->assertRedirect(route('checkout5', ['codeunique' => $nowOrder[0]['codebuy']]));
        //shipping address
        $response = $this->get('/checkout5' . "/" . $nowOrder[0]['codebuy']);
        $response->assertViewIs("checkout.shipping"); // view checkout
        $response->assertSee("Choose shipping method"); //view contain the word
        $response->assertSee("SUMMARY"); // view contain the word
        $this->assertEquals($orderdetails[0]["name"], $orderdetails[0]["name"]); // compare price firts prduct
        $response->assertViewHas("items"); // variable in the view
        $response->assertStatus(200);
        //save package
        $response = $this->post('/checkout6', [
            'codeunique' => $nowOrder[0]['codebuy'],
            'user_id' => 0,
            'package_id' => 1,
        ])->assertRedirect(route('checkout7', ['codeunique' => $nowOrder[0]['codebuy']]));
        //verify errors
        $response = $this->post('/startProcessPay', [
            'codeunique' => $nowOrder[0]['codebuy'],
            'user_id' => 0,
            'package_id' => 1,
        ])->assertRedirectContains('https://checkout-co.placetopay.dev/session/');
    }
    /**
     * Feature call page for paying
     *
     * @return void
     */
    public function test_checkout7_redirect_url_for_paying_is_pending()
    {
        $this->withoutExceptionHandling();
        Helper::create_user_anonymous();
        Helper::create_a_package_manually();
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
            'user_surname' => 'Kalel',
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
        //Capture information of client anonymous
        $response = $this->post('/checkout4', [
            'codeunique' => $nowOrder[0]['codebuy'],
            'user_id' => 0,
            'street' => 'calle 5 de febrero',
            'city' => 'Chiapa de Corzo',
            'state' => 'Chiapas',
            'zipcode' => '29160'
        ])->assertRedirect(route('checkout5', ['codeunique' => $nowOrder[0]['codebuy']]));
        //shipping address
        $response = $this->get('/checkout5' . "/" . $nowOrder[0]['codebuy']);
        $response->assertViewIs("checkout.shipping"); // view checkout
        $response->assertSee("Choose shipping method"); //view contain the word
        $response->assertSee("SUMMARY"); // view contain the word
        $this->assertEquals($orderdetails[0]["name"], $orderdetails[0]["name"]); // compare price firts prduct
        $response->assertViewHas("items"); // variable in the view
        $response->assertStatus(200);
        //save package
        $response = $this->post('/checkout6', [
            'codeunique' => $nowOrder[0]['codebuy'],
            'user_id' => 0,
            'package_id' => 1,
        ])->assertRedirect(route('checkout7', ['codeunique' => $nowOrder[0]['codebuy']]));
        //verify errors
        $response = $this->post('/startProcessPay', [
            'codeunique' => $nowOrder[0]['codebuy'],
            'user_id' => 0,
            'package_id' => 1,
        ])->assertRedirectContains('https://checkout-co.placetopay.dev/session/');
        //$processUrl=OrderPayData::where('id','=',$nowOrder[0]['id'])[0]['process_url'];
        $pay=new PayProcessService();
        $this->assertTrue($pay->estatusPayPending($nowOrder[0]['codebuy']));
    }    
}
