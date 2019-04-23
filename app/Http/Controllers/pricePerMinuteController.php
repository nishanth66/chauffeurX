<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatepricePerMinuteRequest;
use App\Http\Requests\UpdatepricePerMinuteRequest;
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
        return view('price_per_minutes.create');
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

        if (empty($pricePerMinute)) {
            Flash::error('Price Per Minute not found');

            return redirect(route('pricePerMinutes.index'));
        }

        return view('price_per_minutes.edit')->with('pricePerMinute', $pricePerMinute);
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
