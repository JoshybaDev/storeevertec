<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Order;
use App\Helpers\Helper;
use App\Models\Product;
use App\Models\OrderDetail;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CheckOutPackageTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Feature verify again
     * Add products to cart
     * Show cart
     * Write data client and does checkout2
     * Show summary data info in checkout3
     * Write address shipping and does checkout4
     * Show list of packages in checakout5
     *
     * @return void
     */
    public function test_checkout_cinco_cliente_anonymous()
    {
        $this->withoutExceptionHandling();
        Helper::create_user_anonymous();
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
        //Capture information of client anonymous
        $response = $this->post('/checkout4', [
            'codeunique' => $nowOrder[0]['codebuy'],
            'user_id' => 0,
            'street' => 'calle 5 de febrero',
            'city' => 'Chiapa de Corzo',
            'state' => 'Chiapas',
            'zipcode' => '29160'
        ])->assertRedirect(route('checkout5', ['codeunique' => $nowOrder[0]['codebuy']]));
        //Consult /checkout5
        $response = $this->get('/checkout5' . "/" . $nowOrder[0]['codebuy']);
        $response->assertViewIs("checkout.shipping"); // view checkout
        $response->assertSee("Choose shipping method"); //view contain the word
        $response->assertSee("SUMMARY"); // view contain the word
        $this->assertEquals($orderdetails[0]["name"], $orderdetails[0]["name"]); // compare price firts prduct
        $response->assertViewHas("items"); // variable in the view
        $response->assertStatus(200);
    }
    /**
     * Feature verify checkout3 codebuy is nulo
     * Get
     * Capture your address
     *
     * @return void
     */
    public function test_code_unique_nulo_in_checkout_cinco()
    {
        $response = $this->get('/checkout5')
            ->assertRedirect(route('products'))
            ->assertSessionHasErrors([
                'codeunique' => 'Your Code is Invalid!!',
            ]);
    }
    /**
     * Feature verify again redirection to checkout5 if 
     * parametes is null
     * Add products to cart
     * Show cart
     * Write data client and does checkout2
     * Show summary data info in checkout3
     * Write address shipping and does checkout4
     * Show list of packages in checakout5
     * write parameters nulo in checkout6
     *
     * @return void
     */
    public function test_checkout_seis_parameters_null()
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
        $response = $this->get('/checkout5' . "/" . $nowOrder[0]['codebuy']);
        $response->assertViewIs("checkout.shipping"); // view checkout
        $response->assertSee("Choose shipping method"); //view contain the word
        $response->assertSee("SUMMARY"); // view contain the word
        $this->assertEquals($orderdetails[0]["name"], $orderdetails[0]["name"]); // compare price firts prduct
        $response->assertViewHas("items"); // variable in the view
        $response->assertStatus(200);
        //save package
        $response = $this->post('/checkout6', [
            // 'codeunique' => $nowOrder[0]['codebuy'],
            // 'user_id' => 0,
            // 'package_id' => 1,
        ])->assertRedirect(route('checkout5', ['codeunique' => $nowOrder[0]['codebuy']]))
            ->assertSessionHasErrors([
                'codeunique' => 'The codeunique field is required.',
                'user_id' => 'The user id field is required.',
                'package_id' => 'The package id field is required.',
            ]);
    }
    /**
     * Feature verify again redirection to checkout7 if 
     * parametes is valid
     * Add products to cart
     * Show cart
     * Write data client and does checkout2
     * Show summary data info in checkout3
     * Write address shipping and does checkout4
     * Show list of packages in checakout5
     * write parameters nulo in checkout6
     *
     * @return void
     */
    public function test_checkout_seis_parameters_valid()
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
    }
    /**
     * Feature verify again redirection to checkout3 if 
     * the order no exists an address
     * Add products to cart
     * Show cart
     * Write data client and does checkout2
     * Show summary data info in checkout3
     * Write address shipping and does checkout4
     * Show list of packages in checakout5
     * write parameters nulo in checkout6
     *
     * @return void
     */
    public function test_checkout_cinco_redirecto3_if_not_exists_address()
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
        //access a to checkout 5
        $response = $this->get('/checkout5' . "/" . $nowOrder[0]['codebuy'])
            ->assertRedirect(route('checkout3', ['codeunique' => $nowOrder[0]['codebuy']]));
    }
    /**
     * Feature verify again redirection to checkout7 if 
     * parametes is valid
     * Add products to cart
     * Show cart
     * Write data client and does checkout2
     * Show summary data info in checkout3
     * Write address shipping and does checkout4
     * Show list of packages in checakout5
     * write parameters nulo in checkout6
     *
     * @return void
     */
    public function test_checkout_cinco_redirecto7_if_exists_address_package()
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
        $response = $this->get('/checkout5' . "/" . $nowOrder[0]['codebuy'])
            ->assertRedirect(route('checkout7', ['codeunique' => $nowOrder[0]['codebuy']]));
    }
}
