<?php

declare(strict_types=1);

namespace Opscale\NovaCatalogs\Tests\Browser;

use Laravel\Dusk\Browser;
use Opscale\NovaCatalogs\Tests\DuskTestCase;
use PHPUnit\Framework\Attributes\Test;

final class CatalogResourceTest extends DuskTestCase
{
    #[Test]
    public function it_logs_into_nova_and_reaches_the_dashboard(): void
    {
        $this->browse(function (Browser $browser): void {
            $this->loginToNova($browser)
                ->assertSee('Get Started');
        });
    }

    #[Test]
    public function it_can_navigate_to_the_catalogs_index(): void
    {
        $this->browse(function (Browser $browser): void {
            $this->loginToNova($browser)
                ->visit('/nova/resources/catalogs')
                ->waitForText('Catalogs')
                ->assertSee('Catalogs');
        });
    }

    #[Test]
    public function it_renders_the_create_catalog_form(): void
    {
        $this->browse(function (Browser $browser): void {
            $this->loginToNova($browser)
                ->visit('/nova/resources/catalogs/new')
                ->waitForText('Create Catalog')
                ->assertSee('Name')
                ->assertSee('Key')
                ->assertSee('Description');
        });
    }

    #[Test]
    public function it_validates_required_fields_on_create(): void
    {
        $this->browse(function (Browser $browser): void {
            $this->loginToNova($browser)
                ->visit('/nova/resources/catalogs/new')
                ->waitForText('Create Catalog')
                ->press('Create Catalog')
                ->waitForText('The Name field is required')
                ->assertSee('The Name field is required');
        });
    }
}
