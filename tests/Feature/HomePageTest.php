<?php

use Tests\TestCase;

class HomePageTest extends TestCase
{
    public function testWelcomeView()
    {
        $response = $this->get('/');

        $response->assertStatus(200)
            ->assertViewIs('welcome')
            ->assertSee('Documentation')
            ->assertSee('Laravel News');
    }
}
