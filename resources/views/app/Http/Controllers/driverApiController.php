<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatedriverApiRequest;
use App\Http\Requests\UpdatedriverApiRequest;
use App\Repositories\driverApiRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class driverApiController extends Controller
{
    /** @var  driverApiRepository */
    private $driverApiRepository;

    public function __construct(driverApiRepository $driverApiRepo)
    {
        $this->driverApiRepository = $driverApiRepo;
    }

    /**
     * Display a listing of the driverApi.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->driverApiRepository->pushCriteria(new RequestCriteria($request));
        $driverApis = $this->driverApiRepository->all();

        return view('driver_apis.index')
            ->with('driverApis', $driverApis);
    }

    /**
     * Show the form for creating a new driverApi.
     *
     * @return Response
     */
    public function create()
    {
        return view('driver_apis.create');
    }

    /**
     * Store a newly created driverApi in storage.
     *
     * @param CreatedriverApiRequest $request
     *
     * @return Response
     */
    public function store(CreatedriverApiRequest $request)
    {
        $input = $request->all();

        $driverApi = $this->driverApiRepository->create($input);

        Flash::success('Driver Api saved successfully.');

        return redirect(route('driverApis.index'));
    }

    /**
     * Display the specified driverApi.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $driverApi = $this->driverApiRepository->findWithoutFail($id);

        if (empty($driverApi)) {
            Flash::error('Driver Api not found');

            return redirect(route('driverApis.index'));
        }

        return view('driver_apis.show')->with('driverApi', $driverApi);
    }

    /**
     * Show the form for editing the specified driverApi.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $driverApi = $this->driverApiRepository->findWithoutFail($id);

        if (empty($driverApi)) {
            Flash::error('Driver Api not found');

            return redirect(route('driverApis.index'));
        }

        return view('driver_apis.edit')->with('driverApi', $driverApi);
    }

    /**
     * Update the specified driverApi in storage.
     *
     * @param  int              $id
     * @param UpdatedriverApiRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatedriverApiRequest $request)
    {
        $driverApi = $this->driverApiRepository->findWithoutFail($id);

        if (empty($driverApi)) {
            Flash::error('Driver Api not found');

            return redirect(route('driverApis.index'));
        }

        $driverApi = $this->driverApiRepository->update($request->all(), $id);

        Flash::success('Driver Api updated successfully.');

        return redirect(route('driverApis.index'));
    }

    /**
     * Remove the specified driverApi from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $driverApi = $this->driverApiRepository->findWithoutFail($id);

        if (empty($driverApi)) {
            Flash::error('Driver Api not found');

            return redirect(route('driverApis.index'));
        }

        $this->driverApiRepository->delete($id);

        Flash::success('Driver Api deleted successfully.');

        return redirect(route('driverApis.index'));
    }
}
