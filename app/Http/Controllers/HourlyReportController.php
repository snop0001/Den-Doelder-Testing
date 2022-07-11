<?php

namespace App\Http\Controllers;

use App\Models\HourlyReport;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HourlyReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order = Order::isInProduction();
        $hourlyReport = $order->hourlyReport;
        return view('hourlyReports.index', compact('order', 'hourlyReport'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('hourlyReports.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        HourlyReport::create($this->validateHourlyReport($request));

        $order = Order::find($request->order_id);
        $hourlyReports = $order->hourlyReports;

        return view('hourlyReports.index', compact('order', 'hourlyReports'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HourlyReport  $hourlyReport
     * @return \Illuminate\Http\Response
     */
    public function show(HourlyReport $hourlyReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HourlyReport  $hourlyReport
     * @return \Illuminate\Http\Response
     */
    public function edit(HourlyReport $hourlyReport)
    {
        // TODO need to have the Edit blade correctly display saved data
        return view('hourlyReports.edit', compact('hourlyReport'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HourlyReport  $hourlyReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HourlyReport $hourlyReport)
    {
        $hourlyReport->update($this->validateHourlyReport($request));

        return redirect(route('hourlyReports.list', ['order' => $hourlyReport->order_id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HourlyReport  $hourlyReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(HourlyReport $hourlyReport)
    {
        //
    }

    /**
     * this function validates the attributes of Retro
     * @param Request $request
     * @return array
     */
    public function validateHourlyReport(Request $request): array
    {
        $validatedAtributes = $request->validate([
            'order_id'=>'integer',
            'def_id'=>'required',
            'extra_info'=>'required',
            'action' =>'string|nullable',
            'abnormality'=> 'string|nullable',
            'approved'=>'required|boolean',
        ]);

        return $validatedAtributes;
    }

    /**
     * Function to list all Hourly Check logs for a specific order
     *
     * @param $details - the order's slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function list(Order $order)
    {
            $hourlyReports = $order->hourlyReports;

        return view('hourlyReports.index', compact('order', 'hourlyReports'));
    }

    /**
     * Function to create an Hourly Check log for a specific order
     *
     * @param $details - the order's slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function add(Order $order)
    {
        $hourlyReports = $order->hourlyReports;

        return view('hourlyReports.create', ['order' => $order, 'hourlyReports' => $hourlyReports]);
    }
}
