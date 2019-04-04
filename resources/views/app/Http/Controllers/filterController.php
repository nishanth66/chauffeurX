<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatefilterRequest;
use App\Http\Requests\UpdatefilterRequest;
use App\Repositories\filterRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class filterController extends Controller
{
    /** @var  filterRepository */
    private $filterRepository;

    public function __construct(filterRepository $filterRepo)
    {
        $this->filterRepository = $filterRepo;
    }

    /**
     * Display a listing of the filter.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->filterRepository->pushCriteria(new RequestCriteria($request));
        $filters = $this->filterRepository->all();

        return view('filters.index')
            ->with('filters', $filters);
    }

    /**
     * Show the form for creating a new filter.
     *
     * @return Response
     */
    public function create()
    {
        return view('filters.create');
    }

    /**
     * Store a newly created filter in storage.
     *
     * @param CreatefilterRequest $request
     *
     * @return Response
     */
    public function store(CreatefilterRequest $request)
    {
        $input = $request->all();

        $filter = $this->filterRepository->create($input);

        Flash::success('Filter saved successfully.');

        return redirect(route('filters.index'));
    }

    /**
     * Display the specified filter.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $filter = $this->filterRepository->findWithoutFail($id);

        if (empty($filter)) {
            Flash::error('Filter not found');

            return redirect(route('filters.index'));
        }

        return view('filters.show')->with('filter', $filter);
    }

    /**
     * Show the form for editing the specified filter.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $filter = $this->filterRepository->findWithoutFail($id);

        if (empty($filter)) {
            Flash::error('Filter not found');

            return redirect(route('filters.index'));
        }

        return view('filters.edit')->with('filter', $filter);
    }

    /**
     * Update the specified filter in storage.
     *
     * @param  int              $id
     * @param UpdatefilterRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatefilterRequest $request)
    {
        $filter = $this->filterRepository->findWithoutFail($id);

        if (empty($filter)) {
            Flash::error('Filter not found');

            return redirect(route('filters.index'));
        }

        $filter = $this->filterRepository->update($request->all(), $id);

        Flash::success('Filter updated successfully.');

        return redirect(route('filters.index'));
    }

    /**
     * Remove the specified filter from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $filter = $this->filterRepository->findWithoutFail($id);

        if (empty($filter)) {
            Flash::error('Filter not found');

            return redirect(route('filters.index'));
        }

        $this->filterRepository->delete($id);

        Flash::success('Filter deleted successfully.');

        return redirect(route('filters.index'));
    }
}
