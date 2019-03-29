<li class="{{ Request::is('cencellations*') ? 'active' : '' }}">
    <a href="{!! url('cencellations') !!}"><i class="fa fa-gift"></i><span>Cancellation</span></a>
</li>

<li class="{{ Request::is('driverDistance*') ? 'active' : '' }}">
    <a href="{!! route('driverDistance.index') !!}"><i class="fa fa-car"></i><span>Display Closest Driver</span></a>
</li>

<li class="{{ Request::is('categories*') ? 'active' : '' }}">
    <a href="{!! route('categories.index') !!}"><i class="fa fa-list-alt"></i><span>Categories</span></a>
</li>

<li class="{{ Request::is('paymentMethod*') ? 'active' : '' }}">
    <a href="{!! route('paymentMethod.index') !!}"><i class="fa fa-money"></i><span>Payment Methods</span></a>
</li>


<li class="{{ Request::is('prices*') ? 'active' : '' }}">
    <a href="{!! route('prices.index') !!}"><i class="fa fa-money"></i><span>Prices</span></a>
</li>

<li class="{{ Request::is('passengerApis*') ? 'active' : '' }}">
    <a href="{!! route('passengerApis.index') !!}"><i class="fa fa-edit"></i><span>Passenger Apis</span></a>
</li>




{{--<li class="{{ Request::is('passengers*') ? 'active' : '' }}">--}}
    {{--<a href="{!! route('passengers.index') !!}"><i class="fa fa-edit"></i><span>Passengers</span></a>--}}
{{--</li>--}}

<li class="{{ Request::is('driverApis*') ? 'active' : '' }}">
    <a href="{!! route('driverApis.index') !!}"><i class="fa fa-edit"></i><span>Driver Apis</span></a>
</li>

