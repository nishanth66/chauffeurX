<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatecencellationRequest;
use App\Http\Requests\UpdatecencellationRequest;
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
        if(cencellation::exists())
        {
            $cencellation = cencellation::first();
            return view('cencellations.edit')->with('cencellation', $cencellation);
        }
        else
        {
            return view('cencellations.create');
        }
    }

    /**
     * Show the form for creating a new cencellation.
     *
     * @return Response
     */
    public function create()
    {
        return view('cencellations.create');
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
        $input = $request->all();

        $cencellation = $this->cencellationRepository->create($input);

        Flash::success('Cancellation saved successfully.');

        return redirect(route('cencellations.index'));
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

            return redirect(route('cencellations.index'));
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

        if (empty($cencellation)) {
            Flash::error('Cancellation not found');

            return redirect(route('cencellations.index'));
        }

        return view('cencellations.edit')->with('cencellation', $cencellation);
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

            return redirect(route('cencellations.index'));
        }

        $cencellation = $this->cencellationRepository->update($request->all(), $id);

        Flash::success('Cancellation updated successfully.');

        return redirect(route('cencellations.index'));
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

            return redirect(route('cencellations.index'));
        }

        $this->cencellationRepository->delete($id);

        Flash::success('Cancellation deleted successfully.');

        return redirect(route('cencellations.index'));
    }
}
