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
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_order()
    {
        //expecting an error of authentication (not using users)
//        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->withoutMiddleware();

//        Session::start();
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
//        $this->withoutExceptionHandling();

        // Act
        $response = parent::post($route,$request);

        // Then
        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseCount('orders', 1);
        $this->assertDatabaseHas('orders', [
            'order_number' => 'test_1'
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_order_with_error()
    {
//        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->withoutMiddleware();
        Session::start();
        // Arrange
        $this->seed('PalletSeeder');
        $this->seed('MachineSeeder');
        $route = route('orders.store');
        $request = [
            'order_number'=>'test_1',
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

        // Then
        $response->assertSessionHasErrors(['pallet_id']);
        $this->assertDatabaseCount('orders', 0);
    }
}
