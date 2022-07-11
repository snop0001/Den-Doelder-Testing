<?php

namespace Tests\Unit;

use App\Http\Controllers\OrderController;
use App\Models\Initial;
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

class editOrder extends TestCase
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
        $this->seed('MaterialSeeder');
    }

    /**
     *Created an order with all the criteria to check the editing
     *
     * @return $order
     */
    public function create_order()
    {
        $material=Material::all()->first();
        $order=Order::factory()->create([
            'order_number'=>'test_1',
            'pallet_id'=>Pallet::all()->first()->id,
            'machine_id'=>Machine::where('id',2)->first()->id,
            'quantity_production'=>100,
            'site_location'=>'Axel',
            'start_date'=>date('Y-m-d H:i:s'),
        ]);
        $orderMaterials=OrderMaterial::factory()->create(['order_id'=>$order->id,'material_id'=>$material->product_id,'total_quantity'=>500]);
        $this->build_event_Listeners();
        $order=Order::all()->first();
        return $order;
    }

    /**
     * A test that checks that an order was created with all the attributes needed without quality check
     * that its status will be Quality Check Pending
     *
     * @return void
     */
    public function test_order_just_created()
    {
        //Arrange
        //machine is set in the seeders
        $this->build_seeders();
        //Act
        $order=$this->create_order();
        //Assert (Then)
        $this->assertTrue($order->status==='Quality Check Pending');
    }

    /**
     * A test that checks if an order was updated so that its start date is null that the status will become admin hold
     *
     * @return void
     */
    public function test_admin_hold_date()
    {
        //Arrange
        $this->build_seeders();
        $order=$this->create_order();
        //Act
        $order->start_date=null;
        $order->save();
        //automatic status change
        $this->build_event_Listeners();
        //getting the same order but after the event listeners
        $order=Order::all()->first();
        //Assert (Then)
        $this->assertTrue($order->status==='Admin Hold');
    }

    /**
     * A test that checks if an order was updated so that its machine is null that the status will become admin hold
     *
     * @return void
     */
    public function test_admin_hold_machine()
    {
        //Arrange
        $this->build_seeders();
        $order=$this->create_order();
        //Act
        $machine=Machine::where('name','None')->first();
        $order->machine_id=$machine->id;
        $order->save();
        //automatic status change
        $this->build_event_Listeners();
        //getting the same order but after the event listeners
        $order=Order::all()->first();
        //Assert (Then)
        $this->assertTrue($order->status==='Admin Hold');
    }

    /**
     * A test that checks if an order was updated so that its materials were deleted that the status will be admin hold
     *
     * @return void
     */
    public function test_admin_hold_materials()
    {
        //Arrange
        $this->build_seeders();
        $order=$this->create_order();
        //Act
        $orderMaterial=OrderMaterial::all()->first()->delete();
        //automatic status change
        $this->build_event_Listeners();
        //getting the same order but after the event listeners
        $order=Order::all()->first();
        //Assert (Then)
        $this->assertTrue($order->status==='Admin Hold');
    }

    /**
     * A test that checks if an order has all requierments (machine,date,materials) and that a quality check was created for it
     * that its status will change to Production Pending
     *
     * @return void
     */
    public function test_production_pending()
    {
        //Arrange
        //seeding everything needed
        $this->build_seeders();
        $order=$this->create_order();
        //Act
        $initialCheck=Initial::factory()->create([
            'onderdek'=>'Brug',
            'order_id' => $order->id,
            'strappenTick'=>'Strappen',
            'kamerTick'=>'Loods',
        ]);
        //calling the event listeners
        $this->build_event_Listeners();
        //making sure we get the order after the event listeners were called
        $order=Order::all()->first();
        //Assert (Then)
        //checking that the status is correct
        $this->assertTrue($order->status=='Production Pending');
    }

    /**
     * A test that checks if an order is canceled its status will be canceled
     *
     * @return void
     */
    public function test_canceled()
    {
        //Arrange
        //seeding everything needed
        //orders are created with the "selected" as default on 0
        $this->build_seeders();
        $order=$this->create_order();
        //Act
        //creating an order controller instance
        $orderController=new OrderController();
        $orderController::cancelOrder($order);
        //Assert
        $this->assertTrue($order->status==='Canceled');
    }

    /**
     * A test that checks if an order is canceled the user will be redirected to the order show page
     *
     * @return void
     */
    public function test_canceled_route()
    {
        //Arrange
        //seeding everything needed
        //orders are created with the "selected" as default on 0
        $this->build_seeders();
        $order=$this->create_order();
        //Act
        //creating an order controller instance
        $orderController=new OrderController();
        $response=$orderController::cancelOrder($order);
        $result= $response->isRedirect('http://localhost/orders/'.$order->id);
        //Assert (Then)
        $this->assertTrue($result);
    }


}
