<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatepassengerApiRequest;
use App\Http\Requests\UpdatepassengerApiRequest;
use App\Repositories\passengerApiRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class passengerApiController extends Controller
{
    /** @var  passengerApiRepository */
    private $passengerApiRepository;

    public function __construct(passengerApiRepository $passengerApiRepo)
    {
        $this->passengerApiRepository = $passengerApiRepo;
    }

    /**
     * Display a listing of the passengerApi.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->passengerApiRepository->pushCriteria(new RequestCriteria($request));
        $passengerApis = $this->passengerApiRepository->all();

        return view('passenger_apis.index')
            ->with('passengerApis', $passengerApis);
    }

    /**
     * Show the form for creating a new passengerApi.
     *
     * @return Response
     */
    public function create()
    {
        return view('passenger_apis.create');
    }

    /**
     * Store a newly created passengerApi in storage.
     *
     * @param CreatepassengerApiRequest $request
     *
     * @return Response
     */
    public function store(CreatepassengerApiRequest $request)
    {
        $input = $request->all();

        $passengerApi = $this->passengerApiRepository->create($input);

        Flash::success('Passenger Api saved successfully.');

        return redirect(route('passengerApis.index'));
    }

    /**
     * Display the specified passengerApi.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $passengerApi = $this->passengerApiRepository->findWithoutFail($id);

        if (empty($passengerApi)) {
            Flash::error('Passenger Api not found');

            return redirect(route('passengerApis.index'));
        }

        return view('passenger_apis.show')->with('passengerApi', $passengerApi);
    }

    /**
     * Show the form for editing the specified passengerApi.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $passengerApi = $this->passengerApiRepository->findWithoutFail($id);

        if (empty($passengerApi)) {
            Flash::error('Passenger Api not found');

            return redirect(route('passengerApis.index'));
        }

        return view('passenger_apis.edit')->with('passengerApi', $passengerApi);
    }

    /**
     * Update the specified passengerApi in storage.
     *
     * @param  int              $id
     * @param UpdatepassengerApiRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatepassengerApiRequest $request)
    {
        $passengerApi = $this->passengerApiRepository->findWithoutFail($id);

        if (empty($passengerApi)) {
            Flash::error('Passenger Api not found');

            return redirect(route('passengerApis.index'));
        }

        $passengerApi = $this->passengerApiRepository->update($request->all(), $id);

        Flash::success('Passenger Api updated successfully.');

        return redirect(route('passengerApis.index'));
    }

    /**
     * Remove the specified passengerApi from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $passengerApi = $this->passengerApiRepository->findWithoutFail($id);

        if (empty($passengerApi)) {
            Flash::error('Passenger Api not found');

            return redirect(route('passengerApis.index'));
        }

        $this->passengerApiRepository->delete($id);

        Flash::success('Passenger Api deleted successfully.');

        return redirect(route('passengerApis.index'));
    }
}
