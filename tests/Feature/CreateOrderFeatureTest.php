<?php

namespace Tests\Feature;

use App\Models\Machine;
use App\Models\Order;
use App\Models\Pallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class CreateOrderFeatureTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Tests that an order is created and stored
     *
     * @return void
     */
    public function test_create_order()
    {
        $this->withoutMiddleware();
        // Arrange
        $this->seed('PalletSeeder');
        $this->seed('MachineSeeder');
        $route = route('orders.store');
        $request = [
            'order_number'=>'test_1',
            'pallet_id'=>Pallet::all()->first()->id,
            'machine_id'=>Machine::where('id',2)->first()->id,
            'quantity_production'=>100,
            'site_location'=>'Axel',
            'start_date'=>date('Y-m-d H:i:s'),
            'production_instructions'=>'insrutctions',
            'type_order'=>false,
            'client_name' => '',
            'status' => 'Admin Hold',
        ];
        // Act
        $response = parent::post($route,$request);

        // Assert (Then)
        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseCount('orders', 1);
        $this->assertDatabaseHas('orders', [
            'order_number' => 'test_1'
        ]);
    }

    /**
     * Tests that an order is not created and stored if the data inserted is wrong
     *
     * @return void
     */
    public function test_create_order_with_error()
    {
        // Arrange
        $this->withoutMiddleware();
        Session::start();
        $this->seed('PalletSeeder');
        $this->seed('MachineSeeder');
        $route = route('orders.store');
        $request = [
            'order_number'=>'test_1',
//             missing field to cause an error
//            'pallet_id'=>Pallet::all()->first()->id,
            'machine_id'=>Machine::where('id',2)->first()->id,
            'quantity_production'=>100,
            'site_location'=>'Axel',
            'start_date'=>date('Y-m-d H:i:s'),
            'production_instructions'=>'insrutctions',
            'type_order'=>false,
            'client_name' => '',
            'status' => 'Admin Hold',
        ];

        // Act
        $response = $this->post($route,$request);

        // Assert (Then)
        $response->assertSessionHasErrors(['pallet_id']);
        $this->assertDatabaseCount('orders', 0);
    }
}
