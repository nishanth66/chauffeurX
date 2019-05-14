<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatedriverTipsRequest;
use App\Http\Requests\UpdatedriverTipsRequest;
use App\Models\availableCities;
use App\Models\categories;
use App\Repositories\driverTipsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class driverTipsController extends Controller
{
    /** @var  driverTipsRepository */

    public function __construct()
    {
        $this->middleware('auth');
//        $this->driverTipsRepository = $driverTipsRepo;
    }

    /**
     * Display a listing of the driverTips.
     *
     * @param Request $request
     * @return Response
     */
    public function index()
    {

        if (Auth::user()->status == 0)
        {
            $i=1;
            if ($message = Session::get('paymentCity'))
            {
                if ($message == 'all')
                {
                    $payments = DB::table('payment_methods')->get();
                }
                else
                {
                    $payments = DB::table('payment_methods')->where('city','like',$message)->get();
                }
            }
            else
            {
                $payments = DB::table('payment_methods')->get();

            }
            $cities = availableCities::get();
            return view('payments.index',compact('payments','i','cities'));

        }
        else
        {
            return view('errors.404');
        }
    }

    /**
     * Show the form for creating a new driverTips.
     *
     * @return Response
     */
    public function create()
    {
        $cities = availableCities::get();
        return view('payments.create',compact('cities'));
    }

    /**
     * Store a newly created driverTips in storage.
     *
     * @param CreatedriverTipsRequest $request
     *
     * @return Response
     */
    public function store(CreatedriverTipsRequest $request)
    {
        $input = $request->except('_token','_method');
        if (DB::table('payment_methods')->where('city',$request->city)->where('name',$request->name)->exists())
        {
            Flash::error("The entry is already Exists! Please try editing it");
            return redirect('paymentMethod');
        }
        $payments = DB::table('payment_methods')->insert($input);

        Flash::success('Payment Methods saved successfully.');

        return redirect('paymentMethod');
    }

    /**
     * Display the specified driverTips.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $payments = DB::table('payment_methods')->whereId($id)->first();

        if (empty($payments)) {
            Flash::error('Payment Method not found');

            return redirect('paymentMethod');
        }

        return view('payments.show')->with('payments', $payments);
    }

    /**
     * Show the form for editing the specified driverTips.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $payments = DB::table('payment_methods')->whereId($id)->first();
        $cities = availableCities::get();
        if (empty($payments)) {
            Flash::error('Payment Method not found');

            return redirect('paymentMethod');
        }

        return view('payments.edit',compact('cities','payments'));
    }

    /**
     * Update the specified driverTips in storage.
     *
     * @param  int              $id
     * @param UpdatedriverTipsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatedriverTipsRequest $request)
    {
        $payments = DB::table('payment_methods')->whereId($id)->first();
        $update = $request->except('_token','_method');
        if (empty($payments)) {
            Flash::error('Payment Method not found');

            return redirect('paymentMethod');
        }
        if (DB::table('payment_methods')->where('city',$request->city)->where('name',$request->name)->where('id','!=',$id)->exists())
        {
            Flash::error("The entry is already Exists! Please try editing it");
            return redirect('paymentMethod');
        }
        $payments = DB::table('payment_methods')->whereId($id)->update($update);

        Flash::success('Payment Method updated successfully.');

        return redirect('paymentMethod');
    }

    /**
     * Remove the specified driverTips from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $payments = DB::table('payment_methods')->whereId($id)->first();

        if (empty($payments)) {
            Flash::error('Payment Method not found');

            return redirect('paymentMethod');
        }

        DB::table('payment_methods')->whereId($id)->delete();

        Flash::success('Payment Method deleted successfully.');

        return redirect('paymentMethod');
    }

    public function changeCity($city)
    {
        Session::put('paymentCity',$city);
        if ($city == 'all')
        {
            $payments = DB::table('payment_methods')->get();
        }
        else
        {
            $payments = DB::table('payment_methods')->where('city','like',$city)->get();
        }
        $result = $this->getPaymentTable($payments);
        return $result;
    }
    public function getPaymentTable($payments)
    {
        $html = <<<EOD
        <!--<table class="table table-responsive" id="drivers-table">-->
            <thead>
                <tr>
                    <th>City</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
EOD;
        foreach ($payments as $payment) {
            $editUrl = route('categories.edit', $payment->id);
            $formUrl = url('category/delete') . '/' . $payment->id;
            $html .= <<<EOD
                <tr>
                    <td>$payment->city</td>
                    <td>$payment->name</td>
                    <td>
                            <div class='btn-group'>
                                <a href="$editUrl" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                                <a href="$formUrl" class="btn btn-danger btn-xs" onclick="return confirm('Are you Sure?')"><i class="glyphicon glyphicon-trash"></i></a>
                            </div>
                    </td>
                </tr>
EOD;
        }
        return $html;
    }
}
