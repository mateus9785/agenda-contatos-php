<?php

namespace Tests\Feature;

use Tests\TestCase;

class ViewTest extends TestCase
{
    public function testPageWelcome()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testPageRegister()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function testPageLogin()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function testPageReset()
    {
        $response = $this->get('/password/reset');

        $response->assertStatus(200);
    }
}
