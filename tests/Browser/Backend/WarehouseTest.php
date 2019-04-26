<?php

namespace Tests\Browser\Backend;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\User;
use App\Models\Warehouse as Module;

class WarehouseTest extends DuskTestCase
{
    /**
     * A basic browser test example for Warehouse Module....
     * @group warehouse
     * @return void
     */
    public function testWarehouse() {
        $this->browse(function (Browser $browser) {
            $user = User::first();

            $browser->pause(3000);

            $browser->loginAs($user)
                    ->visit(route('warehouse.create'));

            $browser->type('name', 'Demo')
					
                    ->press('Save')
                    ->assertRouteIs('warehouse.create')
                    ->pause(3000)
                    ->assertSee('Warehouse Created!')
                    ->visit(route('warehouse.index'));

            $model = Module::latest()->first();
            $browser->click('.custom-default')
                    ->clickLink("Edit")
                    ->visit(route('warehouse.edit', $model->id))
                    ->assertSee('Edit Warehouse')
                    ->type('name', 'Demo')
					
                    ->press('Save')
                    ->assertRouteIs('warehouse.edit', $model->id)
                    ->pause(3000)
                    ->assertSee('Warehouse Updated!')
                    ->visit(route('warehouse.index'))
                    ->pause(2000)
                    ->click('.custom-default')
                    ->clickLink("Delete")
                    ->press("Yes Delete it!")
                    ->pause(3000)
                    ->assertSee('Warehouse Deleted!');
        });
    }
}
