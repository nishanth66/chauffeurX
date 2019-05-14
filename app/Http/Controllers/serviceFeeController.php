<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateserviceFeeRequest;
use App\Http\Requests\UpdateserviceFeeRequest;
use App\Models\availableCities;
use App\Models\categories;
use App\Models\serviceFee;
use App\Repositories\serviceFeeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class serviceFeeController extends Controller
{
    /** @var  serviceFeeRepository */
    private $serviceFeeRepository;

    public function __construct(serviceFeeRepository $serviceFeeRepo)
    {
        $this->middleware('auth');
        $this->serviceFeeRepository = $serviceFeeRepo;
    }

    /**
     * Display a listing of the serviceFee.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->serviceFeeRepository->pushCriteria(new RequestCriteria($request));
        $serviceFees = $this->serviceFeeRepository->all();

        return view('service_fees.index')
            ->with('serviceFees', $serviceFees);
    }

    /**
     * Show the form for creating a new serviceFee.
     *
     * @return Response
     */
    public function create()
    {
        $cities = availableCities::get();
        $categories = categories::get();
        return view('service_fees.create',compact('cities','categories'));
    }

    /**
     * Store a newly created serviceFee in storage.
     *
     * @param CreateserviceFeeRequest $request
     *
     * @return Response
     */
    public function store(CreateserviceFeeRequest $request)
    {
        $input = $request->all();
        if (serviceFee::where('city',$request->city)->where('category',$request->category)->exists())
        {
            Flash::error("Entry is already Exists! Try editing it");
            return redirect(route('serviceFees.index'));
        }
        $serviceFee = $this->serviceFeeRepository->create($input);

        Flash::success('Service Fee saved successfully.');

        return redirect(route('serviceFees.index'));
    }

    /**
     * Display the specified serviceFee.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $serviceFee = $this->serviceFeeRepository->findWithoutFail($id);

        if (empty($serviceFee)) {
            Flash::error('Service Fee not found');

            return redirect(route('serviceFees.index'));
        }

        return view('service_fees.show')->with('serviceFee', $serviceFee);
    }

    /**
     * Show the form for editing the specified serviceFee.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $serviceFee = $this->serviceFeeRepository->findWithoutFail($id);
        $city = availableCities::whereId($serviceFee->city)->first();
        $cities = availableCities::get();
        $categories = categories::where('city','like',$city->city)->get();
        if (empty($serviceFee)) {
            Flash::error('Service Fee not found');

            return redirect(route('serviceFees.index'));
        }

        return view('service_fees.edit',compact('serviceFee','cities','categories'));
    }

    /**
     * Update the specified serviceFee in storage.
     *
     * @param  int              $id
     * @param UpdateserviceFeeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateserviceFeeRequest $request)
    {
        $serviceFee = $this->serviceFeeRepository->findWithoutFail($id);

        if (empty($serviceFee)) {
            Flash::error('Service Fee not found');

            return redirect(route('serviceFees.index'));
        }
        if (serviceFee::where('city',$request->city)->where('category',$request->category)->where('id','!=',$id)->exists())
        {
            Flash::error("Entry is already Exists! Try editing it");
            return redirect(route('serviceFees.index'));
        }
        $serviceFee = $this->serviceFeeRepository->update($request->all(), $id);

        Flash::success('Service Fee updated successfully.');

        return redirect(route('serviceFees.index'));
    }

    /**
     * Remove the specified serviceFee from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $serviceFee = $this->serviceFeeRepository->findWithoutFail($id);

        if (empty($serviceFee)) {
            Flash::error('Service Fee not found');

            return redirect(route('serviceFees.index'));
        }

        $this->serviceFeeRepository->delete($id);

        Flash::success('Service Fee deleted successfully.');

        return redirect(route('serviceFees.index'));
    }
}
