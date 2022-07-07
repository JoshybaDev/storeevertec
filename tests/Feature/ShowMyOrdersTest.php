<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Order;
use App\Helpers\Helper;
use App\Models\Product;
use App\Models\OrderDetail;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowMyOrdersTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Verify a page to login
     *
     * @return void
     */
    public function test_it_visit_page_of_login()
    {
        $this->get('/login')
            ->assertStatus(200)
            ->assertSee('Login');
    }
    /**
     * Login succefull
     *
     * @return void
     */
    public function test_authenticated_to_a_user()
    {
        $this->withoutExceptionHandling();
        Helper::create_user_email_pass('user@mail.com','123456789');
        $this->get('/login')->assertSee('Login');
        $credentials = [
            "email" => "user@mail.com",
            "password" => "123456789"
        ];
        $response = $this->post('/login', $credentials);
        $response->assertRedirect('/home');
        $this->assertCredentials($credentials);
    }
    /**
     * Invalid Credential
     *
     * @return void
     */
    public function test_not_authenticate_to_a_user_with_credentials_invalid()
    {
        Helper::create_user_email_pass('$user@mail.com','123456789');
        $this->get('/login')->assertSee('Login');
        $credentials = [
            "email" => "user@mail.com",
            "password" => "123456789555"
        ];
        $this->assertInvalidCredentials($credentials);
    }
    /**
     * The emails is required
     *
     * @return void
     */
    public function test_the_email_is_required_for_authenticate()
    {
        $credentials = [
            "email" => null,
            "password" => "secret"
        ];
        $response = $this->from('/login')->post('/login', $credentials);
        $response->assertRedirect('/login')->assertSessionHasErrors([
            'email' => 'The email field is required.',
        ]);
    }
    /**
     * The passoword is required
     *
     * @return void
     */
    public function test_the_password_is_required_for_authenticate()
    {
        $credentials = [
            "email" => "user@mail.com",
            "password" => null
        ];
        $response = $this->from('/login')->post('/login', $credentials);
        $response->assertRedirect('/login')
            ->assertSessionHasErrors([
                'password' => 'The password field is required.',
            ]);
    }
    /**
     * Show My orders
     *
     * @return void
     */
    public function test_showMyOrders()
    {
        $this->withoutExceptionHandling();
        Helper::create_user_email_pass('joshybacorp@gmail.com','123456789');
        $this->get('/login')->assertSee('Login');
        $credentials = [
            "email" => "joshybacorp@gmail.com",
            "password" => "123456789"
        ];
        $response = $this->post('/login', $credentials);
        $response->assertRedirect('/home');
        $this->assertCredentials($credentials);
        $this->get('/products');
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
            'user_id' => 1,
            'user_name' => 'Lia',
            'user_surname' => 'Itzel',
            'user_mobile' => '9612386248',
            'user_email' => 'joshybacorp@gmail.com'
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
                     
        $response = $this->get('/orders');
        $response->assertViewIs("order.list"); // view cart
        $response->assertViewHas("orders"); // variable in the view  
        $response->assertSee('My Orders');
        $response->assertSee('List of orders');
        $response->assertSee($nowOrder[0]['codebuy']);
    }
}
