
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
<li class="{{ Request::is('ranks*') ? 'active' : '' }}">
    <a href="{!! route('ranks.index') !!}"><i class="fa fa-trophy"></i><span>Ranks</span></a>
</li>
<li class="{{ Request::is('musicPreferences*') ? 'active' : '' }}">
    <a href="{!! route('musicPreferences.index') !!}"><i class="fa fa-music"></i><span>Music Preferences</span></a>
</li>
<li class="treeview {{ Request::is('createAccountCoins') || Request::is('invitingCoins') || Request::is('sharingCoins') || Request::is('kiloMetreCoins') || Request::is('ridesCoins')|| Request::is('tippingCoins')|| Request::is('addFavoriteCoins')|| Request::is('newCityCoins')|| Request::is('deleteAppCoins')|| Request::is('newCategoryCoins') ? 'active' : '' }}">
    <a href="#"><i class="fa fa-cog"></i> <span>Coins Settings</span>
        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{Request::is('createAccountCoins') ? 'active' : '' }}"><a href="{{url('createAccountCoins')}}"><i class="fa fa-angle-right"></i>Creating Account</a></li>
        <li class="{{Request::is('invitingCoins') ? 'active' : '' }}"><a href="{{url('invitingCoins')}}"><i class="fa fa-angle-right"></i>Inviting</a></li>
        <li class="{{Request::is('sharingCoins') ? 'active' : '' }}"><a href="{{url('sharingCoins')}}"><i class="fa fa-angle-right"></i>Sharing on Social Media</a></li>
        <li class="{{Request::is('kiloMetreCoins') ? 'active' : '' }}"><a href="{{url('kiloMetreCoins')}}"><i class="fa fa-angle-right"></i>KiloMetre</a></li>
        <li class="{{Request::is('ridesCoins') ? 'active' : '' }}"><a href="{{url('ridesCoins')}}"><i class="fa fa-angle-right"></i>Taking Rides</a></li>
        <li class="{{Request::is('tippingCoins') ? 'active' : '' }}"><a href="{{url('tippingCoins')}}"><i class="fa fa-angle-right"></i>Tipping</a></li>
        <li class="{{Request::is('addFavoriteCoins') ? 'active' : '' }}"><a href="{{url('addFavoriteCoins')}}"><i class="fa fa-angle-right"></i>Adding driver as Favorite</a></li>
        <li class="{{Request::is('newCityCoins') ? 'active' : '' }}"><a href="{{url('newCityCoins')}}"><i class="fa fa-angle-right"></i>Using ChauffeurX in New City</a></li>
        <li class="{{Request::is('deleteAppCoins') ? 'active' : '' }}"><a href="{{url('deleteAppCoins')}}"><i class="fa fa-angle-right"></i>Deleting Other App</a></li>
        <li class="{{Request::is('newCategoryCoins') ? 'active' : '' }}"><a href="{{url('newCategoryCoins')}}"><i class="fa fa-angle-right"></i>Trying new Category</a></li>
    </ul>
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



