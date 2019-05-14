<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateavailableCitiesRequest;
use App\Http\Requests\UpdateavailableCitiesRequest;
use App\Models\availableCities;
use App\Repositories\availableCitiesRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class availableCitiesController extends Controller
{
    /** @var  availableCitiesRepository */
    private $availableCitiesRepository;

    public function __construct(availableCitiesRepository $availableCitiesRepo)
    {
        $this->middleware('auth');
        $this->availableCitiesRepository = $availableCitiesRepo;
    }

    /**
     * Display a listing of the availableCities.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->availableCitiesRepository->pushCriteria(new RequestCriteria($request));
        $availableCities = $this->availableCitiesRepository->all();

        return view('available_cities.index')
            ->with('availableCities', $availableCities);
    }

    /**
     * Show the form for creating a new availableCities.
     *
     * @return Response
     */
    public function create()
    {
        return view('available_cities.create');
    }

    /**
     * Store a newly created availableCities in storage.
     *
     * @param CreateavailableCitiesRequest $request
     *
     * @return Response
     */
    public function store(CreateavailableCitiesRequest $request)
    {
        $input = $request->except('_token');
        if (availableCities::where('city',$request->city)->exists())
        {
            Flash::error("The Entry for ".$request->city." is already Exists! Please try Editing it");
            return redirect(route('availableCities.index'));
        }
        else
        {
            $availableCities = availableCities::create($input);
        }

        Flash::success('Available Cities saved successfully.');

        return redirect(route('availableCities.index'));
    }

    /**
     * Display the specified availableCities.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $availableCities = $this->availableCitiesRepository->findWithoutFail($id);

        if (empty($availableCities)) {
            Flash::error('Available Cities not found');

            return redirect(route('availableCities.index'));
        }

        return view('available_cities.show')->with('availableCities', $availableCities);
    }

    /**
     * Show the form for editing the specified availableCities.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $availableCities = $this->availableCitiesRepository->findWithoutFail($id);

        if (empty($availableCities)) {
            Flash::error('Available Cities not found');

            return redirect(route('availableCities.index'));
        }

        return view('available_cities.edit')->with('availableCities', $availableCities);
    }

    /**
     * Update the specified availableCities in storage.
     *
     * @param  int              $id
     * @param UpdateavailableCitiesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateavailableCitiesRequest $request)
    {
        $availableCities = $this->availableCitiesRepository->findWithoutFail($id);

        if (empty($availableCities)) {
            Flash::error('Available Cities not found');

            return redirect(route('availableCities.index'));
        }
        if (availableCities::where('city',$request->city)->where('id','!=',$id)->exists())
        {
            Flash::error("The Entry for ".$request->city." is already Exists! Please try Editing it");
            return redirect(route('availableCities.index'));
        }
        else
        {
            availableCities::where('city',$request->city)->update($request->except('_token','_method'));
        }

        Flash::success('Available Cities updated successfully.');

        return redirect(route('availableCities.index'));
    }

    /**
     * Remove the specified availableCities from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $availableCities = $this->availableCitiesRepository->findWithoutFail($id);

        if (empty($availableCities)) {
            Flash::error('Available Cities not found');

            return redirect(route('availableCities.index'));
        }

        $this->availableCitiesRepository->delete($id);

        Flash::success('Available Cities deleted successfully.');

        return redirect(route('availableCities.index'));
    }
}
