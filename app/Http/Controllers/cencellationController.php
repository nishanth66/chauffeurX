<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatecencellationRequest;
use App\Http\Requests\UpdatecencellationRequest;
use App\Models\availableCities;
use App\Models\cencellation;
use App\Repositories\cencellationRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class cencellationController extends Controller
{
    /** @var  cencellationRepository */
    private $cencellationRepository;

    public function __construct(cencellationRepository $cencellationRepo)
    {
        $this->cencellationRepository = $cencellationRepo;
    }

    /**
     * Display a listing of the cencellation.
     *
     * @param Request $request
     * @return Response
     */
    public function index()
    {
        $cencellations = cencellation::get();
        return view('cencellations.index',compact('cencellations'));
    }

    /**
     * Show the form for creating a new cencellation.
     *
     * @return Response
     */
    public function create()
    {
        $cities = availableCities::get();
        return view('cencellations.create',compact('cities'));
    }

    /**
     * Store a newly created cencellation in storage.
     *
     * @param CreatecencellationRequest $request
     *
     * @return Response
     */
    public function store(CreatecencellationRequest $request)
    {
        $input = $request->except('_token');
        if (cencellation::where('city', $request->city)->exists())
        {
            Flash::error("The Entry for ".$request->city." is already Exists! Please try Editing it");
            return redirect(route('cancellations.index'));
        }
        else
        {
            $cencellation = cencellation::create($input);
        }

        Flash::success('Cancellation saved successfully.');

        return redirect(route('cancellations.index'));
    }

    /**
     * Display the specified cencellation.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $cencellation = $this->cencellationRepository->findWithoutFail($id);

        if (empty($cencellation)) {
            Flash::error('Cancellation not found');

            return redirect(route('cancellations.index'));
        }

        return view('cencellations.show')->with('cencellation', $cencellation);
    }

    /**
     * Show the form for editing the specified cencellation.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $cencellation = $this->cencellationRepository->findWithoutFail($id);
        $cities = availableCities::get();
        if (empty($cencellation)) {
            Flash::error('Cancellation not found');

            return redirect(route('cancellations.index'));
        }

        return view('cencellations.edit',compact('cencellation','cities'));
    }

    /**
     * Update the specified cencellation in storage.
     *
     * @param  int              $id
     * @param UpdatecencellationRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatecencellationRequest $request)
    {
        $cencellation = $this->cencellationRepository->findWithoutFail($id);

        if (empty($cencellation)) {
            Flash::error('Cancellation not found');

            return redirect(route('cancellations.index'));
        }
        if (cencellation::where('city',$request->city)->where('id','!=',$id)->exists())
        {
            Flash::error("The Entry for ".$request->city." is already Exists! Please try Editing it");
            return redirect(route('cancellations.index'));
        }
        else
        {
            $cencellation = $this->cencellationRepository->update($request->all(), $id);
        }

        Flash::success('Cancellation updated successfully.');

        return redirect(route('cancellations.index'));
    }

    /**
     * Remove the specified cencellation from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $cencellation = $this->cencellationRepository->findWithoutFail($id);

        if (empty($cencellation)) {
            Flash::error('Cancellation not found');

            return redirect(route('cancellations.index'));
        }

        $this->cencellationRepository->delete($id);

        Flash::success('Cancellation deleted successfully.');

        return redirect(route('cancellations.index'));
    }
}
