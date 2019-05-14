<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatedriverStripeRequest;
use App\Http\Requests\UpdatedriverStripeRequest;
use App\Repositories\driverStripeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class driverStripeController extends AppBaseController
{
    /** @var  driverStripeRepository */
    private $driverStripeRepository;

    public function __construct(driverStripeRepository $driverStripeRepo)
    {
        $this->driverStripeRepository = $driverStripeRepo;
    }

    /**
     * Display a listing of the driverStripe.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->driverStripeRepository->pushCriteria(new RequestCriteria($request));
        $driverStripes = $this->driverStripeRepository->all();

        return view('driver_stripes.index')
            ->with('driverStripes', $driverStripes);
    }

    /**
     * Show the form for creating a new driverStripe.
     *
     * @return Response
     */
    public function create()
    {
        return view('driver_stripes.create');
    }

    /**
     * Store a newly created driverStripe in storage.
     *
     * @param CreatedriverStripeRequest $request
     *
     * @return Response
     */
    public function store(CreatedriverStripeRequest $request)
    {
        $input = $request->all();

        $driverStripe = $this->driverStripeRepository->create($input);

        Flash::success('Driver Stripe saved successfully.');

        return redirect(route('driverStripes.index'));
    }

    /**
     * Display the specified driverStripe.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $driverStripe = $this->driverStripeRepository->findWithoutFail($id);

        if (empty($driverStripe)) {
            Flash::error('Driver Stripe not found');

            return redirect(route('driverStripes.index'));
        }

        return view('driver_stripes.show')->with('driverStripe', $driverStripe);
    }

    /**
     * Show the form for editing the specified driverStripe.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $driverStripe = $this->driverStripeRepository->findWithoutFail($id);

        if (empty($driverStripe)) {
            Flash::error('Driver Stripe not found');

            return redirect(route('driverStripes.index'));
        }

        return view('driver_stripes.edit')->with('driverStripe', $driverStripe);
    }

    /**
     * Update the specified driverStripe in storage.
     *
     * @param  int              $id
     * @param UpdatedriverStripeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatedriverStripeRequest $request)
    {
        $driverStripe = $this->driverStripeRepository->findWithoutFail($id);

        if (empty($driverStripe)) {
            Flash::error('Driver Stripe not found');

            return redirect(route('driverStripes.index'));
        }

        $driverStripe = $this->driverStripeRepository->update($request->all(), $id);

        Flash::success('Driver Stripe updated successfully.');

        return redirect(route('driverStripes.index'));
    }

    /**
     * Remove the specified driverStripe from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $driverStripe = $this->driverStripeRepository->findWithoutFail($id);

        if (empty($driverStripe)) {
            Flash::error('Driver Stripe not found');

            return redirect(route('driverStripes.index'));
        }

        $this->driverStripeRepository->delete($id);

        Flash::success('Driver Stripe deleted successfully.');

        return redirect(route('driverStripes.index'));
    }
}
