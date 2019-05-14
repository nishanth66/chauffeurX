<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatepassengerPaymentRequest;
use App\Http\Requests\UpdatepassengerPaymentRequest;
use App\Repositories\passengerPaymentRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class passengerPaymentController extends AppBaseController
{
    /** @var  passengerPaymentRepository */
    private $passengerPaymentRepository;

    public function __construct(passengerPaymentRepository $passengerPaymentRepo)
    {
        $this->passengerPaymentRepository = $passengerPaymentRepo;
    }

    /**
     * Display a listing of the passengerPayment.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->passengerPaymentRepository->pushCriteria(new RequestCriteria($request));
        $passengerPayments = $this->passengerPaymentRepository->all();

        return view('passenger_payments.index')
            ->with('passengerPayments', $passengerPayments);
    }

    /**
     * Show the form for creating a new passengerPayment.
     *
     * @return Response
     */
    public function create()
    {
        return view('passenger_payments.create');
    }

    /**
     * Store a newly created passengerPayment in storage.
     *
     * @param CreatepassengerPaymentRequest $request
     *
     * @return Response
     */
    public function store(CreatepassengerPaymentRequest $request)
    {
        $input = $request->all();

        $passengerPayment = $this->passengerPaymentRepository->create($input);

        Flash::success('Passenger Payment saved successfully.');

        return redirect(route('passengerPayments.index'));
    }

    /**
     * Display the specified passengerPayment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $passengerPayment = $this->passengerPaymentRepository->findWithoutFail($id);

        if (empty($passengerPayment)) {
            Flash::error('Passenger Payment not found');

            return redirect(route('passengerPayments.index'));
        }

        return view('passenger_payments.show')->with('passengerPayment', $passengerPayment);
    }

    /**
     * Show the form for editing the specified passengerPayment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $passengerPayment = $this->passengerPaymentRepository->findWithoutFail($id);

        if (empty($passengerPayment)) {
            Flash::error('Passenger Payment not found');

            return redirect(route('passengerPayments.index'));
        }

        return view('passenger_payments.edit')->with('passengerPayment', $passengerPayment);
    }

    /**
     * Update the specified passengerPayment in storage.
     *
     * @param  int              $id
     * @param UpdatepassengerPaymentRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatepassengerPaymentRequest $request)
    {
        $passengerPayment = $this->passengerPaymentRepository->findWithoutFail($id);

        if (empty($passengerPayment)) {
            Flash::error('Passenger Payment not found');

            return redirect(route('passengerPayments.index'));
        }

        $passengerPayment = $this->passengerPaymentRepository->update($request->all(), $id);

        Flash::success('Passenger Payment updated successfully.');

        return redirect(route('passengerPayments.index'));
    }

    /**
     * Remove the specified passengerPayment from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $passengerPayment = $this->passengerPaymentRepository->findWithoutFail($id);

        if (empty($passengerPayment)) {
            Flash::error('Passenger Payment not found');

            return redirect(route('passengerPayments.index'));
        }

        $this->passengerPaymentRepository->delete($id);

        Flash::success('Passenger Payment deleted successfully.');

        return redirect(route('passengerPayments.index'));
    }
}
