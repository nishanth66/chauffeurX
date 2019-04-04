<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatedriverRequest;
use App\Http\Requests\UpdatedriverRequest;
use App\Repositories\driverRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class driverController extends AppBaseController
{
    /** @var  driverRepository */
    private $driverRepository;

    public function __construct(driverRepository $driverRepo)
    {
        $this->driverRepository = $driverRepo;
    }

    /**
     * Display a listing of the driver.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->driverRepository->pushCriteria(new RequestCriteria($request));
        $drivers = $this->driverRepository->all();

        return view('drivers.index')
            ->with('drivers', $drivers);
    }

    /**
     * Show the form for creating a new driver.
     *
     * @return Response
     */
    public function create()
    {
        return view('drivers.create');
    }

    /**
     * Store a newly created driver in storage.
     *
     * @param CreatedriverRequest $request
     *
     * @return Response
     */
    public function store(CreatedriverRequest $request)
    {
        $input = $request->all();

        $driver = $this->driverRepository->create($input);

        Flash::success('Driver saved successfully.');

        return redirect(route('drivers.index'));
    }

    /**
     * Display the specified driver.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $driver = $this->driverRepository->findWithoutFail($id);

        if (empty($driver)) {
            Flash::error('Driver not found');

            return redirect(route('drivers.index'));
        }

        return view('drivers.show')->with('driver', $driver);
    }

    /**
     * Show the form for editing the specified driver.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $driver = $this->driverRepository->findWithoutFail($id);

        if (empty($driver)) {
            Flash::error('Driver not found');

            return redirect(route('drivers.index'));
        }

        return view('drivers.edit')->with('driver', $driver);
    }

    /**
     * Update the specified driver in storage.
     *
     * @param  int              $id
     * @param UpdatedriverRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatedriverRequest $request)
    {
        $driver = $this->driverRepository->findWithoutFail($id);

        if (empty($driver)) {
            Flash::error('Driver not found');

            return redirect(route('drivers.index'));
        }

        $driver = $this->driverRepository->update($request->all(), $id);

        Flash::success('Driver updated successfully.');

        return redirect(route('drivers.index'));
    }

    /**
     * Remove the specified driver from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $driver = $this->driverRepository->findWithoutFail($id);

        if (empty($driver)) {
            Flash::error('Driver not found');

            return redirect(route('drivers.index'));
        }

        $this->driverRepository->delete($id);

        Flash::success('Driver deleted successfully.');

        return redirect(route('drivers.index'));
    }
}
