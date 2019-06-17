<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatedriverPaymentHistoryRequest;
use App\Http\Requests\UpdatedriverPaymentHistoryRequest;
use App\Repositories\driverPaymentHistoryRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class driverPaymentHistoryController extends Controller
{
    /** @var  driverPaymentHistoryRepository */
    private $driverPaymentHistoryRepository;

    public function __construct(driverPaymentHistoryRepository $driverPaymentHistoryRepo)
    {
        $this->driverPaymentHistoryRepository = $driverPaymentHistoryRepo;
    }

    /**
     * Display a listing of the driverPaymentHistory.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->driverPaymentHistoryRepository->pushCriteria(new RequestCriteria($request));
        $driverPaymentHistories = $this->driverPaymentHistoryRepository->all();

        return view('driver_payment_histories.index')
            ->with('driverPaymentHistories', $driverPaymentHistories);
    }

    /**
     * Show the form for creating a new driverPaymentHistory.
     *
     * @return Response
     */
    public function create()
    {
        return view('driver_payment_histories.create');
    }

    /**
     * Store a newly created driverPaymentHistory in storage.
     *
     * @param CreatedriverPaymentHistoryRequest $request
     *
     * @return Response
     */
    public function store(CreatedriverPaymentHistoryRequest $request)
    {
        $input = $request->all();

        $driverPaymentHistory = $this->driverPaymentHistoryRepository->create($input);

        Flash::success('Driver Payment History saved successfully.');

        return redirect(route('driverPaymentHistories.index'));
    }

    /**
     * Display the specified driverPaymentHistory.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $driverPaymentHistory = $this->driverPaymentHistoryRepository->findWithoutFail($id);

        if (empty($driverPaymentHistory)) {
            Flash::error('Driver Payment History not found');

            return redirect(route('driverPaymentHistories.index'));
        }

        return view('driver_payment_histories.show')->with('driverPaymentHistory', $driverPaymentHistory);
    }

    /**
     * Show the form for editing the specified driverPaymentHistory.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $driverPaymentHistory = $this->driverPaymentHistoryRepository->findWithoutFail($id);

        if (empty($driverPaymentHistory)) {
            Flash::error('Driver Payment History not found');

            return redirect(route('driverPaymentHistories.index'));
        }

        return view('driver_payment_histories.edit')->with('driverPaymentHistory', $driverPaymentHistory);
    }

    /**
     * Update the specified driverPaymentHistory in storage.
     *
     * @param  int              $id
     * @param UpdatedriverPaymentHistoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatedriverPaymentHistoryRequest $request)
    {
        $driverPaymentHistory = $this->driverPaymentHistoryRepository->findWithoutFail($id);

        if (empty($driverPaymentHistory)) {
            Flash::error('Driver Payment History not found');

            return redirect(route('driverPaymentHistories.index'));
        }

        $driverPaymentHistory = $this->driverPaymentHistoryRepository->update($request->all(), $id);

        Flash::success('Driver Payment History updated successfully.');

        return redirect(route('driverPaymentHistories.index'));
    }

    /**
     * Remove the specified driverPaymentHistory from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $driverPaymentHistory = $this->driverPaymentHistoryRepository->findWithoutFail($id);

        if (empty($driverPaymentHistory)) {
            Flash::error('Driver Payment History not found');

            return redirect(route('driverPaymentHistories.index'));
        }

        $this->driverPaymentHistoryRepository->delete($id);

        Flash::success('Driver Payment History deleted successfully.');

        return redirect(route('driverPaymentHistories.index'));
    }
}
