<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatepricePerMinuteRequest;
use App\Http\Requests\UpdatepricePerMinuteRequest;
use App\Models\availableCities;
use App\Models\categories;
use App\Models\pricePerMinute;
use App\Repositories\pricePerMinuteRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class pricePerMinuteController extends Controller
{
    /** @var  pricePerMinuteRepository */
    private $pricePerMinuteRepository;

    public function __construct(pricePerMinuteRepository $pricePerMinuteRepo)
    {
        $this->middleware('auth');
        $this->pricePerMinuteRepository = $pricePerMinuteRepo;
    }

    /**
     * Display a listing of the pricePerMinute.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->pricePerMinuteRepository->pushCriteria(new RequestCriteria($request));
        $pricePerMinutes = $this->pricePerMinuteRepository->all();

        return view('price_per_minutes.index')
            ->with('pricePerMinutes', $pricePerMinutes);
    }

    /**
     * Show the form for creating a new pricePerMinute.
     *
     * @return Response
     */
    public function create()
    {
        $cities = availableCities::get();
        $categories = categories::get();
        return view('price_per_minutes.create',compact('cities','categories'));
    }

    /**
     * Store a newly created pricePerMinute in storage.
     *
     * @param CreatepricePerMinuteRequest $request
     *
     * @return Response
     */
    public function store(CreatepricePerMinuteRequest $request)
    {
        $input = $request->all();

        if (pricePerMinute::where('city',$request->city)->where('category',$request->category)->exists())
        {
            Flash::error("Entry Already exists! Please try Editing it");
            return redirect(route('pricePerMinutes.index'));
        }

        $pricePerMinute = $this->pricePerMinuteRepository->create($input);

        Flash::success('Price Per Minute saved successfully.');

        return redirect(route('pricePerMinutes.index'));
    }

    /**
     * Display the specified pricePerMinute.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $pricePerMinute = $this->pricePerMinuteRepository->findWithoutFail($id);

        if (empty($pricePerMinute)) {
            Flash::error('Price Per Minute not found');

            return redirect(route('pricePerMinutes.index'));
        }

        return view('price_per_minutes.show')->with('pricePerMinute', $pricePerMinute);
    }

    /**
     * Show the form for editing the specified pricePerMinute.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $pricePerMinute = $this->pricePerMinuteRepository->findWithoutFail($id);
        $cities = availableCities::get();
        $city = availableCities::whereId($pricePerMinute->city)->first();
        $categories = categories::where('city','like',$city->city)->get();
        if (empty($pricePerMinute)) {
            Flash::error('Price Per Minute not found');

            return redirect(route('pricePerMinutes.index'));
        }

        return view('price_per_minutes.edit',compact('pricePerMinute','cities','categories'));
    }

    /**
     * Update the specified pricePerMinute in storage.
     *
     * @param  int              $id
     * @param UpdatepricePerMinuteRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatepricePerMinuteRequest $request)
    {
        $pricePerMinute = $this->pricePerMinuteRepository->findWithoutFail($id);

        if (empty($pricePerMinute)) {
            Flash::error('Price Per Minute not found');

            return redirect(route('pricePerMinutes.index'));
        }

        if (pricePerMinute::where('city',$request->city)->where('category',$request->category)->where('id','!=',$id)->exists())
        {
            Flash::error("Entry Already exists! Please try Editing it");
            return redirect(route('pricePerMinutes.index'));
        }

        $pricePerMinute = $this->pricePerMinuteRepository->update($request->all(), $id);

        Flash::success('Price Per Minute updated successfully.');

        return redirect(route('pricePerMinutes.index'));
    }

    /**
     * Remove the specified pricePerMinute from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $pricePerMinute = $this->pricePerMinuteRepository->findWithoutFail($id);

        if (empty($pricePerMinute)) {
            Flash::error('Price Per Minute not found');

            return redirect(route('pricePerMinutes.index'));
        }

        $this->pricePerMinuteRepository->delete($id);

        Flash::success('Price Per Minute deleted successfully.');

        return redirect(route('pricePerMinutes.index'));
    }
}
