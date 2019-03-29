<li class="{{ Request::is('cencellations*') ? 'active' : '' }}">
    <a href="{!! url('cencellations') !!}"><i class="fa fa-gift"></i><span>Cancellation</span></a>
</li>

<li class="{{ Request::is('categories*') ? 'active' : '' }}">
    <a href="{!! route('categories.index') !!}"><i class="fa fa-list-alt"></i><span>Categories</span></a>
</li>


<li class="{{ Request::is('prices*') ? 'active' : '' }}">
    <a href="{!! route('prices.index') !!}"><i class="fa fa-money"></i><span>Prices</span></a>
</li>

<li class="{{ Request::is('passengerApis*') ? 'active' : '' }}">
    <a href="{!! route('passengerApis.index') !!}"><i class="fa fa-edit"></i><span>Passenger Apis</span></a>
</li>

<li class="{{ Request::is('advertisements*') ? 'active' : '' }}">
    <a href="{!! route('advertisements.index') !!}"><i class="fa fa-edit"></i><span>Advertisements</span></a>
</li>

<li class="{{ Request::is('passengers*') ? 'active' : '' }}">
    <a href="{!! route('passengers.index') !!}"><i class="fa fa-edit"></i><span>Passengers</span></a>
</li>

<li class="{{ Request::is('driverApis*') ? 'active' : '' }}">
    <a href="{!! route('driverApis.index') !!}"><i class="fa fa-edit"></i><span>Driver Apis</span></a>
</li>

<li class="{{ Request::is('passengerRatings*') ? 'active' : '' }}">
    <a href="{!! route('passengerRatings.index') !!}"><i class="fa fa-edit"></i><span>Passenger Ratings</span></a>
</li>

