<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

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
                'codeunique'=>'Your Code is Invalid!!',
            ]);
    }
    
}
