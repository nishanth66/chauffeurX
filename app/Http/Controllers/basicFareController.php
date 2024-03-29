<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatebasicFareRequest;
use App\Http\Requests\UpdatebasicFareRequest;
use App\Models\availableCities;
use App\Models\basicFare;
use App\Models\categories;
use App\Repositories\basicFareRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class basicFareController extends Controller
{
    /** @var  basicFareRepository */
    private $basicFareRepository;

    public function __construct(basicFareRepository $basicFareRepo)
    {
        $this->middleware('auth');
        $this->basicFareRepository = $basicFareRepo;
    }

    /**
     * Display a listing of the basicFare.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->basicFareRepository->pushCriteria(new RequestCriteria($request));
        $basicFares = $this->basicFareRepository->all();

        return view('basic_fares.index')
            ->with('basicFares', $basicFares);
    }

    /**
     * Show the form for creating a new basicFare.
     *
     * @return Response
     */
    public function create()
    {
        $cities = availableCities::get();
        $categories = categories::get();
        return view('basic_fares.create',compact('cities','categories'));
    }

    /**
     * Store a newly created basicFare in storage.
     *
     * @param CreatebasicFareRequest $request
     *
     * @return Response
     */
    public function store(CreatebasicFareRequest $request)
    {
        $input = $request->all();

        if (basicFare::where('city',$request->city)->where('category',$request->category)->exists())
        {
            Flash::error("This entry is already Exists! Please try editing it");
            return redirect(route('basicFares.index'));
        }

        $basicFare = $this->basicFareRepository->create($input);

        Flash::success('Basic Fare saved successfully.');

        return redirect(route('basicFares.index'));
    }

    /**
     * Display the specified basicFare.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $basicFare = $this->basicFareRepository->findWithoutFail($id);

        if (empty($basicFare)) {
            Flash::error('Basic Fare not found');

            return redirect(route('basicFares.index'));
        }

        return view('basic_fares.show')->with('basicFare', $basicFare);
    }

    /**
     * Show the form for editing the specified basicFare.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $basicFare = $this->basicFareRepository->findWithoutFail($id);
        $city = availableCities::whereId($basicFare->city)->first();
        $cities = availableCities::get();
        $categories = categories::where('city','like',$city->city)->get();
        if (empty($basicFare)) {
            Flash::error('Basic Fare not found');

            return redirect(route('basicFares.index'));
        }

        return view('basic_fares.edit',compact('basicFare','cities','categories'));
    }

    /**
     * Update the specified basicFare in storage.
     *
     * @param  int              $id
     * @param UpdatebasicFareRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatebasicFareRequest $request)
    {
        $basicFare = $this->basicFareRepository->findWithoutFail($id);

        if (empty($basicFare)) {
            Flash::error('Basic Fare not found');

            return redirect(route('basicFares.index'));
        }
        if (basicFare::where('city',$request->city)->where('category',$request->category)->where('id','!=',$id)->exists())
        {
            Flash::error("This entry is already Exists! Please try editing it");
            return redirect(route('basicFares.index'));
        }
        $basicFare = $this->basicFareRepository->update($request->all(), $id);

        Flash::success('Basic Fare updated successfully.');

        return redirect(route('basicFares.index'));
    }

    /**
     * Remove the specified basicFare from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $basicFare = $this->basicFareRepository->findWithoutFail($id);

        if (empty($basicFare)) {
            Flash::error('Basic Fare not found');

            return redirect(route('basicFares.index'));
        }

        $this->basicFareRepository->delete($id);

        Flash::success('Basic Fare deleted successfully.');

        return redirect(route('basicFares.index'));
    }
}
