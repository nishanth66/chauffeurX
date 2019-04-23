<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateminimumFareRequest;
use App\Http\Requests\UpdateminimumFareRequest;
use App\Repositories\minimumFareRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class minimumFareController extends Controller
{
    /** @var  minimumFareRepository */
    private $minimumFareRepository;

    public function __construct(minimumFareRepository $minimumFareRepo)
    {
        $this->minimumFareRepository = $minimumFareRepo;
    }

    /**
     * Display a listing of the minimumFare.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->minimumFareRepository->pushCriteria(new RequestCriteria($request));
        $minimumFares = $this->minimumFareRepository->all();

        return view('minimum_fares.index')
            ->with('minimumFares', $minimumFares);
    }

    /**
     * Show the form for creating a new minimumFare.
     *
     * @return Response
     */
    public function create()
    {
        return view('minimum_fares.create');
    }

    /**
     * Store a newly created minimumFare in storage.
     *
     * @param CreateminimumFareRequest $request
     *
     * @return Response
     */
    public function store(CreateminimumFareRequest $request)
    {
        $input = $request->all();

        $minimumFare = $this->minimumFareRepository->create($input);

        Flash::success('Minimum Fare saved successfully.');

        return redirect(route('minimumFares.index'));
    }

    /**
     * Display the specified minimumFare.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $minimumFare = $this->minimumFareRepository->findWithoutFail($id);

        if (empty($minimumFare)) {
            Flash::error('Minimum Fare not found');

            return redirect(route('minimumFares.index'));
        }

        return view('minimum_fares.show')->with('minimumFare', $minimumFare);
    }

    /**
     * Show the form for editing the specified minimumFare.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $minimumFare = $this->minimumFareRepository->findWithoutFail($id);

        if (empty($minimumFare)) {
            Flash::error('Minimum Fare not found');

            return redirect(route('minimumFares.index'));
        }

        return view('minimum_fares.edit')->with('minimumFare', $minimumFare);
    }

    /**
     * Update the specified minimumFare in storage.
     *
     * @param  int              $id
     * @param UpdateminimumFareRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateminimumFareRequest $request)
    {
        $minimumFare = $this->minimumFareRepository->findWithoutFail($id);

        if (empty($minimumFare)) {
            Flash::error('Minimum Fare not found');

            return redirect(route('minimumFares.index'));
        }

        $minimumFare = $this->minimumFareRepository->update($request->all(), $id);

        Flash::success('Minimum Fare updated successfully.');

        return redirect(route('minimumFares.index'));
    }

    /**
     * Remove the specified minimumFare from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $minimumFare = $this->minimumFareRepository->findWithoutFail($id);

        if (empty($minimumFare)) {
            Flash::error('Minimum Fare not found');

            return redirect(route('minimumFares.index'));
        }

        $this->minimumFareRepository->delete($id);

        Flash::success('Minimum Fare deleted successfully.');

        return redirect(route('minimumFares.index'));
    }
}
