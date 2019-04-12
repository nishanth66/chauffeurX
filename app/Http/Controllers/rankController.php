<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreaterankRequest;
use App\Http\Requests\UpdaterankRequest;
use App\Repositories\rankRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class rankController extends AppBaseController
{
    /** @var  rankRepository */
    private $rankRepository;

    public function __construct(rankRepository $rankRepo)
    {
        $this->rankRepository = $rankRepo;
    }

    /**
     * Display a listing of the rank.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->rankRepository->pushCriteria(new RequestCriteria($request));
        $ranks = $this->rankRepository->all();

        return view('ranks.index')
            ->with('ranks', $ranks);
    }

    /**
     * Show the form for creating a new rank.
     *
     * @return Response
     */
    public function create()
    {
        return view('ranks.create');
    }

    /**
     * Store a newly created rank in storage.
     *
     * @param CreaterankRequest $request
     *
     * @return Response
     */
    public function store(CreaterankRequest $request)
    {
        $input = $request->all();

        $rank = $this->rankRepository->create($input);

        Flash::success('Rank saved successfully.');

        return redirect(route('ranks.index'));
    }

    /**
     * Display the specified rank.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $rank = $this->rankRepository->findWithoutFail($id);

        if (empty($rank)) {
            Flash::error('Rank not found');

            return redirect(route('ranks.index'));
        }

        return view('ranks.show')->with('rank', $rank);
    }

    /**
     * Show the form for editing the specified rank.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $rank = $this->rankRepository->findWithoutFail($id);

        if (empty($rank)) {
            Flash::error('Rank not found');

            return redirect(route('ranks.index'));
        }

        return view('ranks.edit')->with('rank', $rank);
    }

    /**
     * Update the specified rank in storage.
     *
     * @param  int              $id
     * @param UpdaterankRequest $request
     *
     * @return Response
     */
    public function update($id, UpdaterankRequest $request)
    {
        $rank = $this->rankRepository->findWithoutFail($id);

        if (empty($rank)) {
            Flash::error('Rank not found');

            return redirect(route('ranks.index'));
        }

        $rank = $this->rankRepository->update($request->all(), $id);

        Flash::success('Rank updated successfully.');

        return redirect(route('ranks.index'));
    }

    /**
     * Remove the specified rank from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $rank = $this->rankRepository->findWithoutFail($id);

        if (empty($rank)) {
            Flash::error('Rank not found');

            return redirect(route('ranks.index'));
        }

        $this->rankRepository->delete($id);

        Flash::success('Rank deleted successfully.');

        return redirect(route('ranks.index'));
    }
}
