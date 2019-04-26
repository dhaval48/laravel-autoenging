<?php

namespace Tests\Browser\Backend;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\User;
use App\Models\Demo as Module;

class DemoTest extends DuskTestCase
{
    /**
     * A basic browser test example for Demo Module....
     * @group demo
     * @return void
     */
    public function testDemo() {
        $this->browse(function (Browser $browser) {
            $user = User::first();

            $browser->pause(3000);

            $browser->loginAs($user)
                    ->visit(route('demo.create'));

            $browser->type('name', 'Demo')
					->value('#date', date('m/d/Y'))
					->select('warehouse_id',1)
					->select('gender', 1)
					->type('description', 'Text Area.Demo Test')
					
                    ->press('Save')
                    ->assertRouteIs('demo.create')
                    ->pause(3000)
                    ->assertSee('Demo Created!')
                    ->visit(route('demo.index'));

            $model = Module::latest()->first();
            $browser->click('.custom-default')
                    ->clickLink("Edit")
                    ->visit(route('demo.edit', $model->id))
                    ->assertSee('Edit Demo')
                    ->type('name', 'Demo')
					->value('#date', date('m/d/Y'))
					->select('warehouse_id',1)
					->select('gender', 1)
					->type('description', 'Text Area.Demo Test')
					
                    ->press('Save')
                    ->assertRouteIs('demo.edit', $model->id)
                    ->pause(3000)
                    ->assertSee('Demo Updated!')
                    ->visit(route('demo.index'))
                    ->pause(2000)
                    ->click('.custom-default')
                    ->clickLink("Delete")
                    ->press("Yes Delete it!")
                    ->pause(3000)
                    ->assertSee('Demo Deleted!');
        });
    }
}
