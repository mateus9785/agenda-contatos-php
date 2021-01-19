<?php

namespace Tests\Feature;

use Tests\TestCase;

class ViewTest extends TestCase
{
    /**
     * Testa a visualizacao da pagina de boas vindas
     *
     * @return void
     */

    public function testPageWelcome()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Testa a visualizacao da pagina de cadastro
     *
     * @return void
     */

    public function testPageRegister()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    /**
     * Testa a visualizacao da pagina de login
     *
     * @return void
     */

    public function testPageLogin()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    /**
     * Testa a visualizacao da pagina de mudança de senha
     *
     * @return void
     */

    public function testPageReset()
    {
        $response = $this->get('/password/reset');

        $response->assertStatus(200);
    }
}
