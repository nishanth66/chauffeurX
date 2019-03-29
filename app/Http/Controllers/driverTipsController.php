<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatedriverTipsRequest;
use App\Http\Requests\UpdatedriverTipsRequest;
use App\Repositories\driverTipsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class driverTipsController extends AppBaseController
{
    /** @var  driverTipsRepository */
    private $driverTipsRepository;

    public function __construct(driverTipsRepository $driverTipsRepo)
    {
        $this->driverTipsRepository = $driverTipsRepo;
    }

    /**
     * Display a listing of the driverTips.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->driverTipsRepository->pushCriteria(new RequestCriteria($request));
        $driverTips = $this->driverTipsRepository->all();

        return view('driver_tips.index')
            ->with('driverTips', $driverTips);
    }

    /**
     * Show the form for creating a new driverTips.
     *
     * @return Response
     */
    public function create()
    {
        return view('driver_tips.create');
    }

    /**
     * Store a newly created driverTips in storage.
     *
     * @param CreatedriverTipsRequest $request
     *
     * @return Response
     */
    public function store(CreatedriverTipsRequest $request)
    {
        $input = $request->all();

        $driverTips = $this->driverTipsRepository->create($input);

        Flash::success('Driver Tips saved successfully.');

        return redirect(route('driverTips.index'));
    }

    /**
     * Display the specified driverTips.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $driverTips = $this->driverTipsRepository->findWithoutFail($id);

        if (empty($driverTips)) {
            Flash::error('Driver Tips not found');

            return redirect(route('driverTips.index'));
        }

        return view('driver_tips.show')->with('driverTips', $driverTips);
    }

    /**
     * Show the form for editing the specified driverTips.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $driverTips = $this->driverTipsRepository->findWithoutFail($id);

        if (empty($driverTips)) {
            Flash::error('Driver Tips not found');

            return redirect(route('driverTips.index'));
        }

        return view('driver_tips.edit')->with('driverTips', $driverTips);
    }

    /**
     * Update the specified driverTips in storage.
     *
     * @param  int              $id
     * @param UpdatedriverTipsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatedriverTipsRequest $request)
    {
        $driverTips = $this->driverTipsRepository->findWithoutFail($id);

        if (empty($driverTips)) {
            Flash::error('Driver Tips not found');

            return redirect(route('driverTips.index'));
        }

        $driverTips = $this->driverTipsRepository->update($request->all(), $id);

        Flash::success('Driver Tips updated successfully.');

        return redirect(route('driverTips.index'));
    }

    /**
     * Remove the specified driverTips from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $driverTips = $this->driverTipsRepository->findWithoutFail($id);

        if (empty($driverTips)) {
            Flash::error('Driver Tips not found');

            return redirect(route('driverTips.index'));
        }

        $this->driverTipsRepository->delete($id);

        Flash::success('Driver Tips deleted successfully.');

        return redirect(route('driverTips.index'));
    }
}
