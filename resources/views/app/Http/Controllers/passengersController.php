<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatepassengersRequest;
use App\Http\Requests\UpdatepassengersRequest;
use App\Repositories\passengersRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class passengersController extends AppBaseController
{
    /** @var  passengersRepository */
    private $passengersRepository;

    public function __construct(passengersRepository $passengersRepo)
    {
        $this->passengersRepository = $passengersRepo;
    }

    /**
     * Display a listing of the passengers.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->passengersRepository->pushCriteria(new RequestCriteria($request));
        $passengers = $this->passengersRepository->all();

        return view('passengers.index')
            ->with('passengers', $passengers);
    }

    /**
     * Show the form for creating a new passengers.
     *
     * @return Response
     */
    public function create()
    {
        return view('passengers.create');
    }

    /**
     * Store a newly created passengers in storage.
     *
     * @param CreatepassengersRequest $request
     *
     * @return Response
     */
    public function store(CreatepassengersRequest $request)
    {
        $input = $request->all();

        $passengers = $this->passengersRepository->create($input);

        Flash::success('Passengers saved successfully.');

        return redirect(route('passengers.index'));
    }

    /**
     * Display the specified passengers.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $passengers = $this->passengersRepository->findWithoutFail($id);

        if (empty($passengers)) {
            Flash::error('Passengers not found');

            return redirect(route('passengers.index'));
        }

        return view('passengers.show')->with('passengers', $passengers);
    }

    /**
     * Show the form for editing the specified passengers.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $passengers = $this->passengersRepository->findWithoutFail($id);

        if (empty($passengers)) {
            Flash::error('Passengers not found');

            return redirect(route('passengers.index'));
        }

        return view('passengers.edit')->with('passengers', $passengers);
    }

    /**
     * Update the specified passengers in storage.
     *
     * @param  int              $id
     * @param UpdatepassengersRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatepassengersRequest $request)
    {
        $passengers = $this->passengersRepository->findWithoutFail($id);

        if (empty($passengers)) {
            Flash::error('Passengers not found');

            return redirect(route('passengers.index'));
        }

        $passengers = $this->passengersRepository->update($request->all(), $id);

        Flash::success('Passengers updated successfully.');

        return redirect(route('passengers.index'));
    }

    /**
     * Remove the specified passengers from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $passengers = $this->passengersRepository->findWithoutFail($id);

        if (empty($passengers)) {
            Flash::error('Passengers not found');

            return redirect(route('passengers.index'));
        }

        $this->passengersRepository->delete($id);

        Flash::success('Passengers deleted successfully.');

        return redirect(route('passengers.index'));
    }
}
