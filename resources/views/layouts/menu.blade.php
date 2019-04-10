
@if(Auth::user()->status == 0 || Auth::user()->status == 1)
<li class="{{ Request::is('cencellations*') ? 'active' : '' }}">
    <a href="{!! url('cencellations') !!}"><i class="fa fa-gift"></i><span>Cancellation</span></a>
</li>

<li class="{{ Request::is('driverDistance*') ? 'active' : '' }}">
    <a href="{!! route('driverDistance.index') !!}"><i class="fa fa-car"></i><span>Display Closest Driver</span></a>
</li>
<li class="{{ Request::is('ad-distance*') ? 'active' : '' }}">
    <a href="{!! url('ad-distance') !!}"><i class="fa fa-car"></i><span>Ads near Destination</span></a>
</li>

<li class="{{ Request::is('advertisements*') ? 'active' : '' }}">
    <a href="{!! route('advertisements.index') !!}"><i class="fa fa-bullhorn"></i><span>Advertisement</span></a>
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

<li class="{{ Request::is('templates*') ? 'active' : '' }}">
    <a href="{!! route('templates.index') !!}"><i class="fa fa-columns"></i><span>Notification Template</span></a>
</li>
@if(Auth::user()->status == 1)
<li class="{{ Request::is('passengerApis*') ? 'active' : '' }}">
    <a href="{!! route('passengerApis.index') !!}"><i class="fa fa-edit"></i><span>Passenger Apis</span></a>
</li>

<li class="{{ Request::is('driverApis*') ? 'active' : '' }}">
    <a href="{!! route('driverApis.index') !!}"><i class="fa fa-edit"></i><span>Driver Apis</span></a>
</li>

@endif
@endif
{{--<li class="{{ Request::is('filters*') ? 'active' : '' }}">--}}
    {{--<a href="{!! route('filters.index') !!}"><i class="fa fa-filter"></i><span>Filters</span></a>--}}
{{--</li>--}}

{{--<li class="{{ Request::is('notifications*') ? 'active' : '' }}">--}}
    {{--<a href="{!! route('notifications.index') !!}"><i class="fa fa-edit"></i><span>Notifications</span></a>--}}
{{--</li>--}}




