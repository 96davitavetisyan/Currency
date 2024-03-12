<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class CurrencyTest extends TestCase
{
    public function testIndex()
    {
        $response = $this->get('/api/currencies');

        $response->assertStatus(200);
    }

    public function testShow()
    {
        $response = $this->get('/api/currencies/2023-01-01');

        $response->assertStatus(200);
    }

    public function testUpdate()
    {
        $response = $this->post('/api/currencies/update');

        $response->assertStatus(200);
    }
}
