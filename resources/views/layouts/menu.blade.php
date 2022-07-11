@if(((Auth::user()->role === 'Production') && (\App\Models\Order::isInProduction(Auth::user()->machine) !== 'no production'))
|| (((Auth::user()->role === 'Administrator' && !Request::is('reports*'))||Auth::user()->role === 'Driver') && ($order !== null)))
    <div class="info-box shade brand-text">
        <div class="info-box-content">
            <h4><span class="info-box-text">Order #{{$order->order_number}}</span></h4>
            <h5>
                    <span class="align-content-lg-stretch d-flex justify-content-center badge
                @if($order->status === 'Production Pending')
                        badge-secondary
                @elseif($order->status === 'In Production')
                        badge-info
                @elseif(($order->status === 'Paused') || ($order->status === 'Admin Hold'))
                        badge-warning
                @elseif($order->status === 'Done')
                        badge-success
                @elseif($order->status === 'Quality Check Pending')
                        bg-lightblue
                @elseif($order->status === 'Canceled')
                        badge-dark
                @endif
                        ">{{Auth::user()->role !== 'Production' ? '' . $order->status :$order->status}}</span>
            </h5>
            @if(Auth::user()->role !== 'Production')
                <h5>
                    <span class="align-content-lg-stretch d-flex justify-content-center badge
                @if($order->truckDriver_status === 'Production Pending' || $order->truckDriver_status === null)
                        badge-secondary
                @elseif($order->truckDriver_status === 'Driving')
                        badge-info
                @elseif($order->truckDriver_status === 'Paused')
                        badge-warning
                @elseif($order->truckDriver_status === 'Done')
                        badge-success
                @endif
                        ">
                        @if($order->truckDriver_status === null)
                            No Driver
                        @else
                            {{$order->truckDriver_status}}
                        @endif
                    </span>
                </h5>
            @endif
        </div>
    </div>
@endif
{{--checking role if production worker--}}
@if(Auth::user()->role === 'Production')
    {{--    Production Status (either 1 is in production or Paused --}}
    @if($order !== null)
        <li class="nav-item">
            <div class="card bg-gray-dark" style="margin-bottom: .2rem">
                @if($order->status === 'Paused')
                    <a class="nav-item">
                        <button type="button" class="far fas fa-arrow-alt-circle-up btn btn-success btn-block"
                                data-toggle="modal"
                                data-target="#restartProd">
                            Restart
                        </button>
                    </a>
                @endif
                @if($order->status === 'In Production')
                    <a class="nav-item">
                        <button type="button" class="far fa-pause-circle btn btn-warning btn-block"
                                data-toggle="modal"
                                data-target="#pauseProd">
                            Pause
                        </button>

                    </a>
                    <a class="nav-item">
                        <button type="button" class="far fa-stop-circle btn btn-danger btn-block "
                                data-toggle="modal"
                                data-target="#finishOrder">
                            Finish Order
                        </button>
                    </a>
                @endif
            </div>

            <div class="nav-item">
                <a href="{{ route('orders.show', $order) }}" class="nav-link active btn text-left bg-gray-dark">
                    <i class="nav-icon fas fa-clipboard-list"></i>
                    <p>Order Details</p>
                </a>
                @if($order->status === 'In Production')
                    <a href="{{route('initial.show', $order->id)}}" class="nav-link active bg-gray-dark btn text-left">
                        <i class="nav-icon fas fa-clipboard-check"></i>
                        <p> Initial Check</p>
                    </a>
                    <a href="{{route('pallets.show', $order->pallet)}}"
                       class="nav-link active bg-gray-dark btn text-left">
                        <i class="nav-icon fas fa-draw-polygon"></i>
                        <p>Drawings</p>
                    </a>

                    @if(\App\Models\Order::prodCheckExists($order))
                        <a href="{{route('production.show', $order->id)}}"
                           class="nav-link active bg-gray-dark btn text-left">
                            <i class="nav-icon fas fa-tools"></i>
                            <p>Production Check</p>
                        </a>
                    @else
                        <a href="{{route('production.create')}}" class="nav-link active bg-gray-dark btn text-left">
                            <i class="nav-icon fas fa-tools"></i>
                            <p> Add Production Check</p>
                        </a>
                    @endif
                    <a href="{{ route('hourlyReports.list', $order) }}"
                       class="nav-link active bg-gray-dark btn text-left">
                        <i class="nav-icon fas fa-check"></i>
                        <p>Hourly Check</p>
                    </a>
                @endif
            </div>
            <div class="nav-item">
                <a href="{{route('notes.index')}}" class="nav-link active bg-gray-dark btn text-left">
                    <i class="nav-icon fas fa-book"></i>
                    <p>Notes</p>
                </a>
                @if($order->status === 'In Production')
                    <a class="nav-link active bg-gray-dark btn text-left"
                       data-toggle="modal"
                       data-target="#logPallets">
                        <i class="nav-icon fas fa-clipboard-check"></i>
                        <p>Log Pallets</p>
                    </a>
                @endif
            </div>
        </li>
        {{--    No Production (no In Production Or Pause) --}}
    @else
        <li class="nav-item">
            <div class="nav-item">
                <a href="{{ route('machines.show', ['machine' =>Auth::user()->machine]) }}"
                   class="nav-link active btn bg-gray-dark">
                    <i class="nav-icon fas fa-clipboard-list"></i>
                    <p>Orders</p>
                </a>
            </div>
        </li>
    @endif
    {{--    checks if the role is of administrator--}}
@elseif(Auth::user()->role === 'Administrator')
    @if(Request::is('reports*'))
        <li class="nav-item">
            <div class="nav-item">
                <a href="{{ route('reports.show', 1) }}" class="nav-link active btn bg-gray-dark text-left">
                    <i class="nav-icon fas fa-dice-one"></i>
                    <p>Cape 1</p>
                </a>
            </div>
        </li>
        <li class="nav-item">
            <div class="nav-item">
                <a href="{{ route('reports.show', 2) }}" class="nav-link active btn bg-gray-dark text-left">
                    <i class="nav-icon fas fa-dice-two"></i>
                    <p>Cape 2</p>
                </a>
            </div>
        </li>
        <li class="nav-item">
            <div class="nav-item">
                <a href="{{ route('reports.show', 5) }}" class="nav-link active btn bg-gray-dark text-left">
                    <i class="nav-icon fas fa-dice-five"></i>
                    <p>Cape 5</p>
                </a>
            </div>
        </li>
    @else
        @if($order === null)
            <li class="nav-item">
                <div class="nav-item">
                    <a href="{{ route('orders.index') }}" class="nav-link active btn bg-gray-dark">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>Orders</p>
                    </a>
                </div>
            </li>
        @else
            <li class="nav-item">
                <div class="nav-item">
                    <form method="POST" action="{{route('orders.unselectOrder', $order)}}"
                          class="nav-link active btn text-left bg-success">
                        @csrf

                        <button type="submit" class="button-without-style">
                            <i class="nav-icon fas fa-arrow-alt-circle-up text-left"></i>
                            <p class="brand-text">Back to Overview</p>
                        </button>
                    </form>

                    <a href="{{ route('orders.show',$order) }}" class="nav-link active btn text-left bg-gray-dark">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>Order Details</p>
                    </a>
                    @if(\App\Models\Order::initialCheckExists($order))
                        <a href="{{route('initial.show', $order->id)}}"
                           class="nav-link active bg-gray-dark btn text-left">
                            <i class="nav-icon fas fa-clipboard-check"></i>
                            <p> Initial Check</p>
                        </a>
                    @else
                        <a href="{{route('initial.create')}}" class="nav-link active bg-gray-dark btn text-left">
                            <i class="nav-icon fas fa-clipboard-check"></i>
                            <p> Add Initial Check</p>
                        </a>
                    @endif
                    <a href="{{route('pallets.show', $order->pallet)}}"
                       class="nav-link active bg-gray-dark btn text-left">
                        <i class="nav-icon fas fa-draw-polygon"></i>
                        <p>Drawings</p>
                    </a>
                    @if($order->production !== null)
                        <a href="{{route('production.show', $order)}}"
                           class="nav-link active bg-gray-dark btn text-left">
                            <i class="nav-icon fas fa-tools"></i>
                            <p>Production Check</p>
                        </a>
                    @endif

                    <a href="{{ route('hourlyReports.list', $order) }}"
                       class="nav-link active bg-gray-dark btn text-left">
                        <i class="nav-icon fas fa-check"></i>
                        <p>Hourly Check</p>
                    </a>
                    <a href="{{route('notes.index')}}" class="nav-link active bg-gray-dark btn text-left">
                        <i class="nav-icon fas fa-book"></i>
                        <p>Notes</p>
                    </a>
                </div>
            </li>
        @endif
    @endif
@elseif (Auth::user()->role === 'Driver')
    @if(isset($order))
        @if($order->truckDriver_status === 'Driving')
            <li class="nav-item">
                <div class="card bg-gray-dark" style="margin-bottom: .2rem">
                    <a class="nav-item">
                        <button type="button" class="nav-link active btn text-left bg-warning"
                                data-toggle="modal"
                                data-target="#pauseDriving">
                            <i class="nav-icon fas fa-pause-circle text-left" style="color: white"></i>
                            <p class="brand-text" style="color: white"> Pause Driving</p>
                        </button>
                    </a>
                    <a class="nav-item">
                        <button type="button" class="nav-link active btn text-left bg-danger"
                                data-toggle="modal"
                                data-target="#finishDriving">
                            <i class="nav-icon fas fa-stop-circle text-left"></i>
                            <p class="brand-text"> Finish Driving</p>
                        </button>
                    </a>
                </div>
            <li class="nav-item">
                <div class="nav-item">
                    <a href="{{ route('orders.show',$order) }}" class="nav-link active btn text-left bg-gray-dark">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>Order Details</p>
                    </a>

                    <a href="{{ route('hourlyReports.list', $order) }}"
                       class="nav-link active bg-gray-dark btn text-left">
                        <i class="nav-icon fas fa-check"></i>
                        <p>Hourly Check</p>
                    </a>

                    <a href="{{route('notes.index')}}" class="nav-link active bg-gray-dark btn text-left">
                        <i class="nav-icon fas fa-book"></i>
                        <p>Notes</p>
                    </a>
                    <a href="{{route('productLocations.list',$order)}}"
                       class="nav-link active bg-gray-dark btn text-left">
                        <i class="nav-icon fas fa-compass"></i>
                        <p>Pallet Locations</p>
                    </a>
                </div>
            </li>
            </li>
        @endif
    @endif
    <li class="nav-item">
        <div class="nav-item">
            <a href="{{ route('truckDrivers.list', ['machine' =>Auth::user()->machine]) }}"
               class="nav-link active btn bg-gray-dark text-left">
                <i class="nav-icon fas fa-bookmark"></i>
                <p>Order List</p>
            </a>
        </div>
    </li>
@endif
