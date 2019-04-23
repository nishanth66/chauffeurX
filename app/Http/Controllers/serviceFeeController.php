<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateserviceFeeRequest;
use App\Http\Requests\UpdateserviceFeeRequest;
use App\Repositories\serviceFeeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class serviceFeeController extends Controller
{
    /** @var  serviceFeeRepository */
    private $serviceFeeRepository;

    public function __construct(serviceFeeRepository $serviceFeeRepo)
    {
        $this->serviceFeeRepository = $serviceFeeRepo;
    }

    /**
     * Display a listing of the serviceFee.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->serviceFeeRepository->pushCriteria(new RequestCriteria($request));
        $serviceFees = $this->serviceFeeRepository->all();

        return view('service_fees.index')
            ->with('serviceFees', $serviceFees);
    }

    /**
     * Show the form for creating a new serviceFee.
     *
     * @return Response
     */
    public function create()
    {
        return view('service_fees.create');
    }

    /**
     * Store a newly created serviceFee in storage.
     *
     * @param CreateserviceFeeRequest $request
     *
     * @return Response
     */
    public function store(CreateserviceFeeRequest $request)
    {
        $input = $request->all();

        $serviceFee = $this->serviceFeeRepository->create($input);

        Flash::success('Service Fee saved successfully.');

        return redirect(route('serviceFees.index'));
    }

    /**
     * Display the specified serviceFee.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $serviceFee = $this->serviceFeeRepository->findWithoutFail($id);

        if (empty($serviceFee)) {
            Flash::error('Service Fee not found');

            return redirect(route('serviceFees.index'));
        }

        return view('service_fees.show')->with('serviceFee', $serviceFee);
    }

    /**
     * Show the form for editing the specified serviceFee.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $serviceFee = $this->serviceFeeRepository->findWithoutFail($id);

        if (empty($serviceFee)) {
            Flash::error('Service Fee not found');

            return redirect(route('serviceFees.index'));
        }

        return view('service_fees.edit')->with('serviceFee', $serviceFee);
    }

    /**
     * Update the specified serviceFee in storage.
     *
     * @param  int              $id
     * @param UpdateserviceFeeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateserviceFeeRequest $request)
    {
        $serviceFee = $this->serviceFeeRepository->findWithoutFail($id);

        if (empty($serviceFee)) {
            Flash::error('Service Fee not found');

            return redirect(route('serviceFees.index'));
        }

        $serviceFee = $this->serviceFeeRepository->update($request->all(), $id);

        Flash::success('Service Fee updated successfully.');

        return redirect(route('serviceFees.index'));
    }

    /**
     * Remove the specified serviceFee from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $serviceFee = $this->serviceFeeRepository->findWithoutFail($id);

        if (empty($serviceFee)) {
            Flash::error('Service Fee not found');

            return redirect(route('serviceFees.index'));
        }

        $this->serviceFeeRepository->delete($id);

        Flash::success('Service Fee deleted successfully.');

        return redirect(route('serviceFees.index'));
    }
}
