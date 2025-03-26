<?php

namespace Aaran\Common\Tests;

use Aaran\Common\Models\State;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StateTest extends TestCase
{
    use RefreshDatabase;

    // Ensures a fresh DB for each test

    /**
     * Test that a State can be created successfully.
     */
    public function test_can_create_city()
    {
//        $this->withoutExceptionHandling();

        $city = State::create([
            'vname' => 'State 1',
            'active_id' => '1',
        ]);

        $this->assertDatabaseHas('states', ['vname' => 'State 1']);
    }

    /**
     * Test that a state can be retrieved by its name.
     */
    public function test_can_retrieve_city_by_name()
    {
        State::create([
            'vname' => 'State 1',
            'active_id' => '1',
        ]);

        $obj = State::where('vname', 'State 1')->first();

        $this->assertNotNull($obj);
    }

    /**
     * Test that a state's domain can be updated.
     */
    public function test_can_update_city()
    {
        $city = State::factory()->create(['vname' => 'new state 1']);

        $city->update(['vname' => 'new state 2']);

        $this->assertDatabaseHas('states', ['vname' => 'new state 2']);
    }

    /**
     * Test that a state can be deleted.
     */
    public function test_can_delete_city()
    {
        $city = State::factory()->create();

        $city->delete();

        $this->assertDatabaseMissing('states', ['id' => $city->id]);
    }
}
