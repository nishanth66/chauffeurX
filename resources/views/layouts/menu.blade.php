
@if(Auth::user()->status == 0)
<li class="{{ Request::is('availableCities*') ? 'active' : '' }}">
    <a href="{!! route('availableCities.index') !!}"><i class="fas fa-city"></i><span>Available Cities</span></a>
</li>

<li class="treeview {{ Request::is('driver/approved*') || Request::is('driver/pending*') || Request::is('driver/rejected*') ? 'active' : '' }}">
    <a href="#"><i class="fas fa-car"></i> <span>Drivers</span>
        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{Request::is('driver/approved*') ? 'active' : '' }}"><a href="{!! url('driver/approved') !!}"><i class="fa fa-angle-right"></i>Approved Drivers</a></li>
        <li class="{{Request::is('driver/pending*') ? 'active' : '' }}"><a href="{!! url('driver/pending') !!}"><i class="fa fa-angle-right"></i>Pending Drivers</a></li>
        <li class="{{Request::is('driver/rejected*') ? 'active' : '' }}"><a href="{!! url('driver/rejected') !!}"><i class="fa fa-angle-right"></i>Rejected Drivers</a></li>

    </ul>
</li>

<li class="{{ Request::is('driverSubscriptions*') ? 'active' : '' }}">
    <a href="{!! url('driverSubscriptions') !!}"><i class="fas fa-sign-in-alt"></i><span>Driver Subscription</span></a>
</li>
<li class="{{ Request::is('adSettings*') ? 'active' : '' }}">
    <a href="{!! route('adSettings.index') !!}"><i class="fas fa-ad"></i><span>Advertisement Settings</span></a>
</li>
<li class="{{ Request::is('adCategories*') ? 'active' : '' }}">
    <a href="{!! route('adCategories.index') !!}"><i class="fa fa-ad"></i><span>Advertisement Categories</span></a>
</li>
<li class="{{ Request::is('cancellations*') ? 'active' : '' }}">
    <a href="{!! url('cancellations') !!}"><i class="fa fa-gift"></i><span>Cancellation</span></a>
</li>

<li class="{{ Request::is('penalty*') ? 'active' : '' }}">
    <a href="{!! url('penalty') !!}"><i class="fa fa-ban"></i><span>Driver Penalty</span></a>
</li>

<li class="{{ Request::is('maximumDistance*') ? 'active' : '' }}">
    <a href="{!! route('maximumDistance.index') !!}"><i class="fa fa-car"></i><span>Maximum Distance</span></a>
</li>

<li class="{{ Request::is('categories*') ? 'active' : '' }}">
    <a href="{!! route('categories.index') !!}"><i class="fa fa-list-alt"></i><span>Categories</span></a>
</li>

<li class="{{ Request::is('paymentMethod*') ? 'active' : '' }}">
    <a href="{!! route('paymentMethod.index') !!}"><i class="fa fa-money"></i><span>Payment Methods</span></a>
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
<li class="{{ Request::is('coins/setting*') ? 'active' : '' }}">
    <a href="{!! url('coins/setting') !!}"><i class="fa fa-cog"></i><span>Coins Settings</span></a>
</li>
<li class="treeview {{ Request::is('basicFares*') || Request::is('pricePerMinutes*') || Request::is('serviceFees*') || Request::is('minimumFares*') || Request::is('prices*') ? 'active' : '' }}">
    <a href="#"><i class="fa fa-cog"></i> <span>Prices</span>
        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{Request::is('basicFares*') ? 'active' : '' }}"><a href="{!! route('basicFares.index') !!}"><i class="fa fa-angle-right"></i>Basic Fare</a></li>
        <li class="{{Request::is('serviceFees*') ? 'active' : '' }}"><a href="{!! route('serviceFees.index') !!}"><i class="fa fa-angle-right"></i>Service Fee</a></li>
        <li class="{{Request::is('minimumFares*') ? 'active' : '' }}"><a href="{!! route('minimumFares.index') !!}"><i class="fa fa-angle-right"></i>Minimum Fare</a></li>
        <li class="{{Request::is('prices*') ? 'active' : '' }}"><a href="{!! route('prices.index') !!}"><i class="fa fa-angle-right"></i>Price Per kilometre</a></li>
        <li class="{{Request::is('pricePerMinutes*') ? 'active' : '' }}"><a href="{!! route('pricePerMinutes.index') !!}"><i class="fa fa-angle-right"></i>Price Per Minute</a></li>
    </ul>
</li>
{{--<li class="treeview {{ Request::is('createAccountCoins') || Request::is('invitingCoins') || Request::is('sharingCoins') || Request::is('kiloMetreCoins') || Request::is('ridesCoins')|| Request::is('tippingCoins')|| Request::is('addFavoriteCoins')|| Request::is('newCityCoins')|| Request::is('deleteAppCoins')|| Request::is('newCategoryCoins') ? 'active' : '' }}">--}}
    {{--<a href="#"><i class="fa fa-cog"></i> <span>Coins Settings</span>--}}
        {{--<span class="pull-right-container">--}}
                {{--<i class="fa fa-angle-left pull-right"></i>--}}
              {{--</span>--}}
    {{--</a>--}}
    {{--<ul class="treeview-menu">--}}
        {{--<li class="{{Request::is('createAccountCoins') ? 'active' : '' }}"><a href="{{url('createAccountCoins')}}"><i class="fa fa-angle-right"></i>Creating Account</a></li>--}}
        {{--<li class="{{Request::is('invitingCoins') ? 'active' : '' }}"><a href="{{url('invitingCoins')}}"><i class="fa fa-angle-right"></i>Inviting</a></li>--}}
        {{--<li class="{{Request::is('sharingCoins') ? 'active' : '' }}"><a href="{{url('sharingCoins')}}"><i class="fa fa-angle-right"></i>Sharing on Social Media</a></li>--}}
        {{--<li class="{{Request::is('kiloMetreCoins') ? 'active' : '' }}"><a href="{{url('kiloMetreCoins')}}"><i class="fa fa-angle-right"></i>KiloMetre</a></li>--}}
        {{--<li class="{{Request::is('ridesCoins') ? 'active' : '' }}"><a href="{{url('ridesCoins')}}"><i class="fa fa-angle-right"></i>Taking Rides</a></li>--}}
        {{--<li class="{{Request::is('tippingCoins') ? 'active' : '' }}"><a href="{{url('tippingCoins')}}"><i class="fa fa-angle-right"></i>Tipping</a></li>--}}
        {{--<li class="{{Request::is('addFavoriteCoins') ? 'active' : '' }}"><a href="{{url('addFavoriteCoins')}}"><i class="fa fa-angle-right"></i>Adding driver as Favorite</a></li>--}}
        {{--<li class="{{Request::is('newCityCoins') ? 'active' : '' }}"><a href="{{url('newCityCoins')}}"><i class="fa fa-angle-right"></i>Using ChauffeurX in New City</a></li>--}}
        {{--<li class="{{Request::is('deleteAppCoins') ? 'active' : '' }}"><a href="{{url('deleteAppCoins')}}"><i class="fa fa-angle-right"></i>Deleting Other App</a></li>--}}
        {{--<li class="{{Request::is('newCategoryCoins') ? 'active' : '' }}"><a href="{{url('newCategoryCoins')}}"><i class="fa fa-angle-right"></i>Trying new Category</a></li>--}}
    {{--</ul>--}}
{{--</li>--}}
{{--@if(Auth::user()->status == 1)--}}
{{--<li class="{{ Request::is('passengerApis*') ? 'active' : '' }}">--}}
    {{--<a href="{!! route('passengerApis.index') !!}"><i class="fa fa-edit"></i><span>Passenger Apis</span></a>--}}
{{--</li>--}}

{{--<li class="{{ Request::is('driverApis*') ? 'active' : '' }}">--}}
    {{--<a href="{!! route('driverApis.index') !!}"><i class="fa fa-edit"></i><span>Driver Apis</span></a>--}}
{{--</li>--}}
{{--@endif--}}
@endif



