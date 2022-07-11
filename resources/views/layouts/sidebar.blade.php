<aside class="main-sidebar sidebar-dark-gray-dark colour-purple elevation-4">
    {{--    <div class="dropdown-toggle" data-toggle="dropdown">--}}

    <div class="brand-link">
        <img src="\img\pallets150.jpg"
             alt="Den Doelder Logo"
             class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light">Den Doelder</span>
    </div>
    <div class="sidebar">
        @if(Auth::user()->role==='Production')
            <h3><span class="badge colour-orange align-content-lg-stretch d-flex justify-content-center brand-text">Production {{ Auth::user()->machine->name }}</span>
            </h3>
        @else
            @if(Request::is('reports*'))
                <h3><span class="badge colour-orange align-content-lg-stretch d-flex justify-content-center brand-text">Admin Reports</span>
                </h3>
                @if(Request::is('reports/1') || Request::is('reports/2') || Request::is('reports/5'))
                    <h3><span
                            class="badge colour-orange align-content-lg-stretch d-flex justify-content-center brand-text">{{$machine->name}}</span>
                    </h3>
                @else
                    <h3><span
                            class="badge colour-orange align-content-lg-stretch d-flex justify-content-center brand-text">Overall</span>
                    </h3>
                @endif
            @else
                <h3><span class="badge colour-orange align-content-lg-stretch d-flex justify-content-center brand-text">{{ Auth::user()->role }} View</span>
                </h3>
            @endif
        @endif
        <nav class="mt-4">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @php
                    use App\Models\Order;
                    use App\Models\TruckDriver;
                    if(Auth::user()->role === 'Production') {
                        $order=Order::getOrder(Auth::user()->machine);
                        } elseif(Auth::user()->role === 'Administrator') {
                        $order = Order::isSelected();
                        } elseif(Auth::user()->role === 'Driver') {
                        $order = TruckDriver::getDrivingOrder(Auth::user()->machine);
                        }
                @endphp
                @include('layouts.menu',['order'=> $order])

            </ul>
        </nav>
    </div>
</aside>
