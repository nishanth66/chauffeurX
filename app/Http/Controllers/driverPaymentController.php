<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatedriverPaymentRequest;
use App\Http\Requests\UpdatedriverPaymentRequest;
use App\Repositories\driverPaymentRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class driverPaymentController extends AppBaseController
{
    /** @var  driverPaymentRepository */
    private $driverPaymentRepository;

    public function __construct(driverPaymentRepository $driverPaymentRepo)
    {
        $this->driverPaymentRepository = $driverPaymentRepo;
    }

    /**
     * Display a listing of the driverPayment.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->driverPaymentRepository->pushCriteria(new RequestCriteria($request));
        $driverPayments = $this->driverPaymentRepository->all();

        return view('driver_payments.index')
            ->with('driverPayments', $driverPayments);
    }

    /**
     * Show the form for creating a new driverPayment.
     *
     * @return Response
     */
    public function create()
    {
        return view('driver_payments.create');
    }

    /**
     * Store a newly created driverPayment in storage.
     *
     * @param CreatedriverPaymentRequest $request
     *
     * @return Response
     */
    public function store(CreatedriverPaymentRequest $request)
    {
        $input = $request->all();

        $driverPayment = $this->driverPaymentRepository->create($input);

        Flash::success('Driver Payment saved successfully.');

        return redirect(route('driverPayments.index'));
    }

    /**
     * Display the specified driverPayment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $driverPayment = $this->driverPaymentRepository->findWithoutFail($id);

        if (empty($driverPayment)) {
            Flash::error('Driver Payment not found');

            return redirect(route('driverPayments.index'));
        }

        return view('driver_payments.show')->with('driverPayment', $driverPayment);
    }

    /**
     * Show the form for editing the specified driverPayment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $driverPayment = $this->driverPaymentRepository->findWithoutFail($id);

        if (empty($driverPayment)) {
            Flash::error('Driver Payment not found');

            return redirect(route('driverPayments.index'));
        }

        return view('driver_payments.edit')->with('driverPayment', $driverPayment);
    }

    /**
     * Update the specified driverPayment in storage.
     *
     * @param  int              $id
     * @param UpdatedriverPaymentRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatedriverPaymentRequest $request)
    {
        $driverPayment = $this->driverPaymentRepository->findWithoutFail($id);

        if (empty($driverPayment)) {
            Flash::error('Driver Payment not found');

            return redirect(route('driverPayments.index'));
        }

        $driverPayment = $this->driverPaymentRepository->update($request->all(), $id);

        Flash::success('Driver Payment updated successfully.');

        return redirect(route('driverPayments.index'));
    }

    /**
     * Remove the specified driverPayment from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $driverPayment = $this->driverPaymentRepository->findWithoutFail($id);

        if (empty($driverPayment)) {
            Flash::error('Driver Payment not found');

            return redirect(route('driverPayments.index'));
        }

        $this->driverPaymentRepository->delete($id);

        Flash::success('Driver Payment deleted successfully.');

        return redirect(route('driverPayments.index'));
    }
}
