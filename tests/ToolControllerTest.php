<?php

namespace Opscale\NovaCatalogs\Tests;

class ToolControllerTest extends TestCase
{
    /** @test */
    public function it_can_can_return_a_response()
    {
        $this
            ->get('nova-vendor/opscale-co/nova-catalogs/endpoint')
            ->assertSuccessful();
    }
}
