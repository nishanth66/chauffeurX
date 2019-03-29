<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatepassengerStripeRequest;
use App\Http\Requests\UpdatepassengerStripeRequest;
use App\Repositories\passengerStripeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class passengerStripeController extends AppBaseController
{
    /** @var  passengerStripeRepository */
    private $passengerStripeRepository;

    public function __construct(passengerStripeRepository $passengerStripeRepo)
    {
        $this->passengerStripeRepository = $passengerStripeRepo;
    }

    /**
     * Display a listing of the passengerStripe.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->passengerStripeRepository->pushCriteria(new RequestCriteria($request));
        $passengerStripes = $this->passengerStripeRepository->all();

        return view('passenger_stripes.index')
            ->with('passengerStripes', $passengerStripes);
    }

    /**
     * Show the form for creating a new passengerStripe.
     *
     * @return Response
     */
    public function create()
    {
        return view('passenger_stripes.create');
    }

    /**
     * Store a newly created passengerStripe in storage.
     *
     * @param CreatepassengerStripeRequest $request
     *
     * @return Response
     */
    public function store(CreatepassengerStripeRequest $request)
    {
        $input = $request->all();

        $passengerStripe = $this->passengerStripeRepository->create($input);

        Flash::success('Passenger Stripe saved successfully.');

        return redirect(route('passengerStripes.index'));
    }

    /**
     * Display the specified passengerStripe.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $passengerStripe = $this->passengerStripeRepository->findWithoutFail($id);

        if (empty($passengerStripe)) {
            Flash::error('Passenger Stripe not found');

            return redirect(route('passengerStripes.index'));
        }

        return view('passenger_stripes.show')->with('passengerStripe', $passengerStripe);
    }

    /**
     * Show the form for editing the specified passengerStripe.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $passengerStripe = $this->passengerStripeRepository->findWithoutFail($id);

        if (empty($passengerStripe)) {
            Flash::error('Passenger Stripe not found');

            return redirect(route('passengerStripes.index'));
        }

        return view('passenger_stripes.edit')->with('passengerStripe', $passengerStripe);
    }

    /**
     * Update the specified passengerStripe in storage.
     *
     * @param  int              $id
     * @param UpdatepassengerStripeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatepassengerStripeRequest $request)
    {
        $passengerStripe = $this->passengerStripeRepository->findWithoutFail($id);

        if (empty($passengerStripe)) {
            Flash::error('Passenger Stripe not found');

            return redirect(route('passengerStripes.index'));
        }

        $passengerStripe = $this->passengerStripeRepository->update($request->all(), $id);

        Flash::success('Passenger Stripe updated successfully.');

        return redirect(route('passengerStripes.index'));
    }

    /**
     * Remove the specified passengerStripe from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $passengerStripe = $this->passengerStripeRepository->findWithoutFail($id);

        if (empty($passengerStripe)) {
            Flash::error('Passenger Stripe not found');

            return redirect(route('passengerStripes.index'));
        }

        $this->passengerStripeRepository->delete($id);

        Flash::success('Passenger Stripe deleted successfully.');

        return redirect(route('passengerStripes.index'));
    }
}
