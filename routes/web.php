<?php

use App\Http\Controllers\{InitialController,
    OrderController,
    HourlyReportController,
    NoteController,
    OrderMaterialController,
    ProductionController,
    PalletController,
    ProductLocationController,
    MachineController,
    ReportController,
    TruckDriverController
};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//home page
Auth::routes();
Route::get('/', function () {
    return view('auth.login');
});

// Machines
Route::resource('/machines', MachineController::class);
// Select machine
Route::post('/machines/{machine}/{user}', [MachineController::class, 'selectMachine'])->name('machines.selectMachine');

// Order
Route::resource('/orders', OrderController::class);

// Pallets
Route::resource('/pallets', PalletController::class);

// Reports
Route::resource('/reports', ReportController::class);

//Production View
//start production route
Route::post('/orders/start/{order}', [OrderController::class, 'startProduction'])->name('orders.startProduction');
//stop production routes
Route::get('/orders/stop/{order}/{machine}/finish', [OrderController::class, 'stopProduction'])->name('orders.stopProduction');
Route::put('/orders/stop/{order}/{machine}', [OrderController::class, 'finishAndLogPallets'])->name('orders.finishAndLogPallets');

//stop production route
Route::post('/orders/pause/{order}', [OrderController::class, 'pauseProduction'])->name('orders.pauseProduction');

//Truck Driver Routes
//start driving route
Route::post('/orders/startDriving/{order}', [OrderController::class, 'startDriving'])->name('orders.startDriving');
//stop driving route
Route::post('/orders/stopDriving/{order}', [OrderController::class, 'stopDriving'])->name('orders.stopDriving');
//stop driving route
Route::post('/orders/pauseDriving/{order}', [OrderController::class, 'pauseDriving'])->name('orders.pauseDriving');


//Admin View
//select
Route::post('/orders/select/{order}', [OrderController::class, 'selectOrder'])->name('orders.selectOrder');
//unselect
Route::post('/orders/unselect/{order}', [OrderController::class, 'unselectOrder'])->name('orders.unselectOrder');
//stop production route
Route::post('/orders/cancel/{order}', [OrderController::class, 'cancelOrder'])->name('orders.cancelOrder');

// OrderMaterials
Route::resource('/orderMaterials', OrderMaterialController::class);

//pallet -sting route
Route::get('/orders/{order}/editquantity', [OrderController::class, 'editquantity'])->name('orders.editquantity');
Route::put('/orders/{order}/updatequantity', [OrderController::class, 'updatequantity'])->name('orders.updatequantity');

//Initial Check
Route::resource('/initial', InitialController::class);

//Production Check
Route::resource('/production', ProductionController::class);

// Hourly Check-up
Route::resource('/hourlyReports', HourlyReportController::class);
Route::get('/hourlyReports/list/{order}', [HourlyReportController::class, 'list'])->name('hourlyReports.list');
Route::get('/hourlyReports/add/{order}', [HourlyReportController::class, 'add'])->name('hourlyReports.add');

// Notes
Route::resource('/notes', NoteController::class);
Route::get('/notes/stoppage/{order}', [NoteController::class, 'stoppage'])->name('notes.stoppage');
Route::get('/notes/fixStoppage/{order}', [NoteController::class, 'fixStoppage'])->name('notes.fixStoppage');

Route::group(['middleware' => ['web']], function () {
    //Double Form Create
    Route::get('/create-step-one', [OrderController::Class, 'createStepOne'])->name('orders.create.step.one');
    Route::post('/create-step-one', [OrderController::class, 'postCreateStepOne'])->name('orders.create.step.one.post');

    Route::get('/create-step-two', [OrderMaterialController::class, 'createStepTwo'])->name('orders.create.step.two');
    Route::post('/create-step-two', [OrderMaterialController::class, 'postCreateStepTwo'])->name('orders.create.step.two.post');

//Double Form Create
    Route::get('/edit-step-one/{order}', [OrderController::Class, 'editStepOne'])->name('orders.edit.step.one');
    Route::put('/edit-step-one/{order}', [OrderController::class, 'updateEditStepOne'])->name('orders.update.step.one.post');


    Route::get('/edit-step-two/{order}', [OrderMaterialController::class, 'editStepTwo'])->name('orders.edit.step.two');
    Route::put('/edit-step-two/{order}', [OrderMaterialController::class, 'updateEditStepTwo'])->name('orders.update.step.two.post');

});


// Locations
Route::resource('/productLocations', ProductLocationController::class);
Route::get('/productLocations/list/{order}', [ProductLocationController::class, 'list'])->name('productLocations.list'); // Custom Index
Route::get('/productLocations/addLocation/{order}', [ProductLocationController::class, 'addLocation'])->name('productLocations.addLocation'); // Custom Create
Route::post('/productLocations/storeLocation/{order}', [ProductLocationController::class, 'storeLocation'])->name('productLocations.storeLocation'); // Custom Store
Route::get('/productLocations/editLocation/{order}/{locationId}', [ProductLocationController::class, 'editLocation'])->name('productLocations.editLocation'); // Custom Edit
Route::put('/productLocations/editLocation/{order}/{locationId}', [ProductLocationController::class, 'updateLocation'])->name('productLocations.updateLocation'); // Custom Update

// Truck Driver - see the list of orders
Route::get('/driver/list/{machine}', [TruckDriverController::class, 'list'])->name('truckDrivers.list');
