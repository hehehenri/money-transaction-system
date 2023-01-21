<?php

namespace Tests\Feature;

use Tests\TestCase;

class HealthCheckTest extends TestCase
{
    /** @test */
    public function itReturnsOk(): void
    {
        $this->getJson('v1/health-check')
            ->assertOk();
    }
}
