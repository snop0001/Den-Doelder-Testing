<?php

namespace Tests\Feature;

use App\Models\Machine;
use App\Models\Material;
use App\Models\Order;
use App\Models\OrderMaterial;
use App\Models\Pallet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class EditOrderFeatureTest extends TestCase
{
    use RefreshDatabase;
    use withoutMiddleware;

    /**
     *Created an order with all the criteria to check the editing
     *
     * @return $order
     */
    public function create_order()
    {
        $order=Order::factory()->create([
            'order_number'=>'test_1',
            'pallet_id'=>Pallet::all()->first()->id,
            'machine_id'=>Machine::where('id',2)->first()->id,
            'quantity_production'=>100,
            'site_location'=>'Axel',
            'start_date'=>date('Y-m-d H:i:s'),
        ]);
        return $order;
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_update_order()
    {
        $this->withoutMiddleware();
        $this->seed('PalletSeeder');
        $this->seed('MachineSeeder');
        $this->seed('OrderSeeder');
        $order=Order::all()->first();
        $route = route('orders.update',['order'=>$order]);
        $request = [
            'order_number'=>'test_update',
        ];
        $response= $this->put($route,$request);
        $order=Order::all()->first();
        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('orders', [
            'order_number' => 'test_update'
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
//        $this->withoutMiddleware();
        $this->seed('PalletSeeder');
        $this->seed('MachineSeeder');
        $this->seed('OrderSeeder');
//        $this->seed('UserSeeder');
//        $user=User::where('role','Administrator')->first();
//        $this->user=$user;
//        $this->actingAs($this->user);
        Session::start();
        $order=Order::all()->first();
        $route = route('orders.update',['order'=>$order]);
        $request = [
            'order_number'=>null,
        ];
        $response= $this->put($route,$request);
        $response->assertSessionHasErrors('order_number');
    }
}
