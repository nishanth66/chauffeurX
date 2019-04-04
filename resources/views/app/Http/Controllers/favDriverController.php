<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatefavDriverRequest;
use App\Http\Requests\UpdatefavDriverRequest;
use App\Repositories\favDriverRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class favDriverController extends AppBaseController
{
    /** @var  favDriverRepository */
    private $favDriverRepository;

    public function __construct(favDriverRepository $favDriverRepo)
    {
        $this->favDriverRepository = $favDriverRepo;
    }

    /**
     * Display a listing of the favDriver.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->favDriverRepository->pushCriteria(new RequestCriteria($request));
        $favDrivers = $this->favDriverRepository->all();

        return view('fav_drivers.index')
            ->with('favDrivers', $favDrivers);
    }

    /**
     * Show the form for creating a new favDriver.
     *
     * @return Response
     */
    public function create()
    {
        return view('fav_drivers.create');
    }

    /**
     * Store a newly created favDriver in storage.
     *
     * @param CreatefavDriverRequest $request
     *
     * @return Response
     */
    public function store(CreatefavDriverRequest $request)
    {
        $input = $request->all();

        $favDriver = $this->favDriverRepository->create($input);

        Flash::success('Fav Driver saved successfully.');

        return redirect(route('favDrivers.index'));
    }

    /**
     * Display the specified favDriver.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $favDriver = $this->favDriverRepository->findWithoutFail($id);

        if (empty($favDriver)) {
            Flash::error('Fav Driver not found');

            return redirect(route('favDrivers.index'));
        }

        return view('fav_drivers.show')->with('favDriver', $favDriver);
    }

    /**
     * Show the form for editing the specified favDriver.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $favDriver = $this->favDriverRepository->findWithoutFail($id);

        if (empty($favDriver)) {
            Flash::error('Fav Driver not found');

            return redirect(route('favDrivers.index'));
        }

        return view('fav_drivers.edit')->with('favDriver', $favDriver);
    }

    /**
     * Update the specified favDriver in storage.
     *
     * @param  int              $id
     * @param UpdatefavDriverRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatefavDriverRequest $request)
    {
        $favDriver = $this->favDriverRepository->findWithoutFail($id);

        if (empty($favDriver)) {
            Flash::error('Fav Driver not found');

            return redirect(route('favDrivers.index'));
        }

        $favDriver = $this->favDriverRepository->update($request->all(), $id);

        Flash::success('Fav Driver updated successfully.');

        return redirect(route('favDrivers.index'));
    }

    /**
     * Remove the specified favDriver from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $favDriver = $this->favDriverRepository->findWithoutFail($id);

        if (empty($favDriver)) {
            Flash::error('Fav Driver not found');

            return redirect(route('favDrivers.index'));
        }

        $this->favDriverRepository->delete($id);

        Flash::success('Fav Driver deleted successfully.');

        return redirect(route('favDrivers.index'));
    }
}
