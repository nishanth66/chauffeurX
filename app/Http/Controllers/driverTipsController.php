<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatedriverTipsRequest;
use App\Http\Requests\UpdatedriverTipsRequest;
use App\Repositories\driverTipsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class driverTipsController extends Controller
{
    /** @var  driverTipsRepository */

    public function __construct()
    {
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
        $i=1;
        $payments = DB::table('payment_methods')->get();
        return view('payments.index',compact('payments','i'));
    }

    /**
     * Show the form for creating a new driverTips.
     *
     * @return Response
     */
    public function create()
    {
        return view('payments.create');
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

        if (empty($payments)) {
            Flash::error('Payment Method not found');

            return redirect('paymentMethod');
        }

        return view('payments.edit')->with('payments', $payments);
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
}
