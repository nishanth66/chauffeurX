<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatedriverSubscriptionRequest;
use App\Http\Requests\UpdatedriverSubscriptionRequest;
use App\Models\availableCities;
use App\Models\categories;
use App\Models\driver;
use App\Models\driverCategory;
use App\Models\driverPaymentHistory;
use App\Models\driverSubscription;
use App\Repositories\driverSubscriptionRepository;
use App\Http\Controllers\AppBaseController;
use Cartalyst\Stripe\Api\Subscriptions;
use Cartalyst\Stripe\Stripe;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Cookie;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class driverSubscriptionController extends Controller
{
    /** @var  driverSubscriptionRepository */
    private $driverSubscriptionRepository;

    public function __construct(driverSubscriptionRepository $driverSubscriptionRepo)
    {
        $this->middleware('auth');
        $this->driverSubscriptionRepository = $driverSubscriptionRepo;
    }

    /**
     * Display a listing of the driverSubscription.
     *
     * @param Request $request
     * @return Response
     */
    public function index()
    {
        $cookie = Cookie::get('citySubscription');
        if ($cookie == '' || empty($cookie))
        {
           Cookie::queue('citySubscription','all');
        }
        $cookie = Cookie::get('citySubscription');
        if ($cookie == '' || empty($cookie))
        {
            $cookie = 'all';
        }
        if ($cookie != 'all')
        {
            $driverSubscriptions = driverSubscription::where('city','like',$cookie)->get();
        }
        else
        {
            $driverSubscriptions = driverSubscription::get();
        }
        $cities = availableCities::get();
        return view('driver_subscriptions.index',compact('driverSubscriptions','cities'));
    }

    /**
     * Show the form for creating a new driverSubscription.
     *
     * @return Response
     */
    public function create()
    {
        $categories = categories::get();
        $cities = availableCities::get();
        return view('driver_subscriptions.create',compact('cities','categories'));
    }

    /**
     * Store a newly created driverSubscription in storage.
     *
     * @param CreatedriverSubscriptionRequest $request
     *
     * @return Response
     */
    public function store(CreatedriverSubscriptionRequest $request)
    {
        $cities = availableCities::whereId($request->city)->first();
        $city = $cities->city;
        $input = $request->all();
        $input['city'] = $city;
        if (driverSubscription::where('city',$city)->where('category',$request->category)->exists())
        {
            Flash::error("Entry is already exists");
            return redirect(route('driverSubscriptions.index'));
        }
        $stripe = Stripe::make(env('STRIPE_SECRET'));
        $plan = $stripe->plans()->create([
            'id'                   => $city.'_monthly_'.$request->category,
            'name'                 => $city.'_monthly('.$request->amount.'$)',
            'amount'               => (float)$request->amount,
            'currency'             => 'USD',
            'interval'             => 'month',
            'statement_descriptor' => 'Monthly Subscription',
        ]);
        $input['stripe_id'] = $plan['id'];
        $driverSubscription = $this->driverSubscriptionRepository->create($input);

        Flash::success('Driver Subscription saved successfully.');

        return redirect(route('driverSubscriptions.index'));
    }

    /**
     * Display the specified driverSubscription.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $driverSubscription = $this->driverSubscriptionRepository->findWithoutFail($id);
        $cities = availableCities::get();
        if (empty($driverSubscription)) {
            Flash::error('Driver Subscription not found');

            return redirect(route('driverSubscriptions.index'));
        }

        return view('driver_subscriptions.show',compact('driverSubscription','cities'));
    }

    /**
     * Show the form for editing the specified driverSubscription.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $categories = categories::get();
        $driverSubscription = $this->driverSubscriptionRepository->findWithoutFail($id);
        $cities = availableCities::get();
        if (empty($driverSubscription)) {
            Flash::error('Driver Subscription not found');

            return redirect(route('driverSubscriptions.index'));
        }

        return view('driver_subscriptions.edit',compact('driverSubscription','cities','categories'));
    }

    /**
     * Update the specified driverSubscription in storage.
     *
     * @param  int              $id
     * @param UpdatedriverSubscriptionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatedriverSubscriptionRequest $request)
    {
        $cities = availableCities::whereId($request->city)->first();
        $city = $cities->city;
        $input = $request->all();
        $input['city'] = $city;
        $driverSubscription = $this->driverSubscriptionRepository->findWithoutFail($id);
        $stripeId = $driverSubscription->stripe_id;
        if (driverSubscription::where('city',$city)->where('category',$request->category)->where('id','!=',$id)->exists())
        {
            Flash::error("Entry is already exists");
            return redirect(route('driverSubscriptions.index'));
        }
        if (empty($driverSubscription)) {
            Flash::error('Driver Subscription not found');

            return redirect(route('driverSubscriptions.index'));
        }

        $driverSubscription = $this->driverSubscriptionRepository->update($input, $id);
        $stripe = Stripe::make(env('STRIPE_SECRET'));
        $plan = $stripe->plans()->delete($stripeId);
        $plan = $stripe->plans()->create([
            'id'                   => $stripeId,
            'name'                 => $driverSubscription->city.'_monthly('.$request->amount.'$)',
            'amount'               => (float)$request->amount,
            'currency'             => 'USD',
            'interval'             => 'month',
            'statement_descriptor' => 'Monthly Subscription',
        ]);
        $drivers = driver::where('city','like',$driverSubscription->city)->where('payment',1)->where('stripeid','!=',null)->orWhere('stripeid','!=','')->get();
        foreach ($drivers  as $driver)
        {
            if(driverCategory::where('driverid',$driver->id)->where('city','like',$driverSubscription->city)->where('categoryid',$request->category)->exists()) {
                $nextDate = date('Y-m-d', $driver->next_pay);
                driver::whereId($driver->id)->update(['next_pay' => strtotime($nextDate)]);
                $history = driverPaymentHistory::where('driverid', $driver->id)->orderby('id', 'desc')->first();
                try {
                    $subscription = $stripe->subscriptions()->update($driver->stripeid, $history->stripe_sub, [
                        'plan' => $stripeId,
                        'trial_end' => $driver->next_pay,
                    ]);
                } catch (\Exception $e) {

                }
            }
        }

        Flash::success('Driver Subscription updated successfully.');

        return redirect(route('driverSubscriptions.index'));
    }

    /**
     * Remove the specified driverSubscription from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $driverSubscription = $this->driverSubscriptionRepository->findWithoutFail($id);

        if (empty($driverSubscription)) {
            Flash::error('Driver Subscription not found');

            return redirect(route('driverSubscriptions.index'));
        }

        $this->driverSubscriptionRepository->delete($id);

        Flash::success('Driver Subscription deleted successfully.');

        return redirect(route('driverSubscriptions.index'));
    }
    public function changeSubscriptionCity($city)
    {
        Cookie::queue('citySubscription', $city);
        return 1;
    }
}
