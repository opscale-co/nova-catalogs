<?php

declare(strict_types=1);

namespace Opscale\NovaCatalogs\Tests\Feature;

use Opscale\NovaCatalogs\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class ToolControllerTest extends TestCase
{
    #[Test]
    public function it_can_return_a_response(): void
    {
        $this
            ->get('nova-vendor/opscale-co/nova-catalogs/test-case')
            ->assertStatus(403);
    }
}
