<?php

namespace Tests\Unit;

use App\Http\Controllers\OrderController;
use App\Models\Machine;
use App\Models\Material;
use App\Models\Order;
use App\Models\OrderMaterial;
use App\Models\Pallet;
use App\Models\User;
use App\Providers\AdminHold;
use App\Providers\AutomaticStatusChange;
use App\Providers\InitialCheckPending;
use App\Providers\ReadyForProductionPending;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class createOrder extends TestCase
{
    use RefreshDatabase;

    /**
     *Creates and calls the nevent listeners
     *
     * @return void
     */
    public function build_event_Listeners()
    {
        $orders = Order::orderBy('machine_id', 'desc')->get();
        $user = User::where('role','Administrator')->first();

        $event=new AutomaticStatusChange($user, $orders);
        $listenerAdminHold = new AdminHold();
        $listenerAdminHold->handle($event);
        $listenerInitialCheck = new InitialCheckPending();
        $listenerInitialCheck->handle($event);
        $listenerProductionPending = new ReadyForProductionPending();
        $listenerProductionPending->handle($event);
    }

    /**
     *Seeds everything that is needed for the tests
     *
     * @return void
     */
    public function build_seeders()
    {
        $this->seed('PalletSeeder');
        $this->seed('MachineSeeder');
        $this->seed('userSeeder');
    }

    /**
     * A test that checks if an order has only the machine (date and materials missing)
     * the status will be admin hold
     *
     * @return void
     */
    public function test_admin_hold_machine()
    {
        //machine is set in the seeders
        $this->build_seeders();
        $order=Order::factory()->create([
            'order_number'=>'test_1',
            'pallet_id'=>Pallet::all()->first()->id,
            'machine_id'=>Machine::where('id',2)->first()->id,
            'quantity_production'=>100,
            'site_location'=>'Axel',
        ]);
        $this->assertTrue($order->status==='Admin Hold');
    }

    /**
     * A test that checks if an order has machine and date (without materials)
     * the status will be admin hold
     *
     * @return void
     */
    public function test_admin_hold_date()
    {
        $this->build_seeders();
        $order=Order::factory()->create([
            'order_number'=>'test_1',
            'pallet_id'=>Pallet::all()->first()->id,
            'machine_id'=>Machine::where('id',2)->first()->id,
            'quantity_production'=>100,
            'site_location'=>'Axel',
            'start_date'=>date('Y-m-d H:i:s'),
        ]);
        $this->build_event_Listeners();
        $this->assertTrue($order->status==='Admin Hold');
    }

    /**
     * A test that checks if an order has all criteria (date, machine and materials) besides the quality check that the status
     * of that order will be Quality Check Pending
     *
     * @return void
     */
    public function test_quality_check_pending()
    {
        //seeding everything needed
        $this->build_seeders();
        //adding seeding of materials for this test
        $this->seed('MaterialSeeder');
        $material=Material::all()->first();
        //getting the order we will be testing
        $order=Order::factory()->create([
            'order_number'=>'test_1',
            'pallet_id'=>Pallet::all()->first()->id,
            'machine_id'=>Machine::where('id',2)->first()->id,
            'quantity_production'=>100,
            'site_location'=>'Axel',
            'start_date'=>date('Y-m-d H:i:s'),
        ]);
        //creating the materials for the order we just created
        $orderMaterials=OrderMaterial::factory()->create(['order_id'=>$order->id,'material_id'=>$material->product_id,'total_quantity'=>500]);
       //calling the event listeners
        $this->build_event_Listeners();
        //making sure we get the order after the event listeners were called
        $order=Order::where('id',$order->id)->first();
        //checking that the status is correct
        $this->assertTrue($order->status==='Quality Check Pending');
    }

    /**
     * A test that checks if no order was selected the function should return null
     *
     * @return void
     */
    public function test_none_is_selected()
    {
        //seeding everything needed
        //orders are created with the "selected" as default on 0
        $this->build_seeders();
        $this->seed('OrderSeeder');
        $order=order::isSelected();
        $this->assertTrue($order===null);
    }

    /**
     * A test that checks if there is an order that is selected its selected attribute should be 1
     *
     * @return void
     */
    public function test_select()
    {
        //seeding everything needed
        //orders are created with the "selected" as default on 0
        $this->build_seeders();
        $this->seed('OrderSeeder');
        //creating an order controller instance
        $orderController=new OrderController();
        $order=Order::all()->first();
        $orderController::selectOrder($order);
        $this->assertTrue($order->selected===1);
    }

    /**
     * A test that checks if there is an order that was selected the function should return that order show page
     *
     * @return void
     */
    public function test_selected_route()
    {
        //seeding everything needed
        //orders are created with the "selected" as default on 0
        $this->build_seeders();
        $this->seed('OrderSeeder');
        //creating an order controller instance
        $orderController=new OrderController();
        $order=Order::all()->first();
        $response=$orderController::selectOrder($order);
        $result= $response->isRedirect('http://localhost/orders/'.$order->id);
        $this->assertTrue($result);
    }

    /**
     * A test that checks if there is an order that was selected if you can select another one as well
     * Should be not possible so the selected attribute for the second order will be 0
     *
     * @return void
     */
    public function test_select_more_than_one()
    {
        //seeding everything needed
        //orders are created with the "selected" as default on 0
        $this->build_seeders();
        $this->seed('OrderSeeder');
        //creating an order controller instance
        $orderController=new OrderController();
        //setting one order to be selected
        $firstOrder=Order::all()->first();
        $orderController::selectOrder($firstOrder);
        //trying to set the second one to selected as well
        $secondOrder=Order::where('id',2)->first();
        $orderController::selectOrder($secondOrder);
        //checking that the selected didnt change to 1 because a different order is already selected
        $this->assertFalse($secondOrder->selected===1);
    }

    /**
     * A test that checks if an order was previously selected and then unselected that
     * the user gets redirected to the orders index page
     *
     * @return void
     */
    public function test_unselect_order_route()
    {
        //seeding everything needed
        //orders are created with the "selected" as default on 0
        $this->build_seeders();
        $this->seed('OrderSeeder');
        //creating an order controller instance
        $orderController=new OrderController();
        //setting one order to be selected
        $order=Order::all()->first();
        $orderController::selectOrder($order);
        //unselecting the order and checking that the route will go back to orders index
        $response=$orderController::unselectOrder($order);
        $result= $response->isRedirect('http://localhost/orders');
        $this->assertTrue($result);
    }

    /**
     * A test that checks if an order was previously selected and then unselected that
     * the selected attribute for that order changes to 0
     *
     * @return void
     */
    public function test_unselect_order()
    {
        //seeding everything needed
        //orders are created with the "selected" as default on 0
        $this->build_seeders();
        $this->seed('OrderSeeder');
        //creating an order controller instance
        $orderController=new OrderController();
        //setting one order to be selected
        $order=Order::all()->first();
        $orderController::selectOrder($order);
        //unselecting the order and checking that the route will go back to orders index
        $orderController::unselectOrder($order);
        $this->assertTrue($order->selected===0);
    }
}
