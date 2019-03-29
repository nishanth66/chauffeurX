<?php

namespace App\Http\Controllers;

use App\Http\Requests\Createpassenger_ratingRequest;
use App\Http\Requests\Updatepassenger_ratingRequest;
use App\Repositories\passenger_ratingRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class passenger_ratingController extends AppBaseController
{
    /** @var  passenger_ratingRepository */
    private $passengerRatingRepository;

    public function __construct(passenger_ratingRepository $passengerRatingRepo)
    {
        $this->passengerRatingRepository = $passengerRatingRepo;
    }

    /**
     * Display a listing of the passenger_rating.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->passengerRatingRepository->pushCriteria(new RequestCriteria($request));
        $passengerRatings = $this->passengerRatingRepository->all();

        return view('passenger_ratings.index')
            ->with('passengerRatings', $passengerRatings);
    }

    /**
     * Show the form for creating a new passenger_rating.
     *
     * @return Response
     */
    public function create()
    {
        return view('passenger_ratings.create');
    }

    /**
     * Store a newly created passenger_rating in storage.
     *
     * @param Createpassenger_ratingRequest $request
     *
     * @return Response
     */
    public function store(Createpassenger_ratingRequest $request)
    {
        $input = $request->all();

        $passengerRating = $this->passengerRatingRepository->create($input);

        Flash::success('Passenger Rating saved successfully.');

        return redirect(route('passengerRatings.index'));
    }

    /**
     * Display the specified passenger_rating.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $passengerRating = $this->passengerRatingRepository->findWithoutFail($id);

        if (empty($passengerRating)) {
            Flash::error('Passenger Rating not found');

            return redirect(route('passengerRatings.index'));
        }

        return view('passenger_ratings.show')->with('passengerRating', $passengerRating);
    }

    /**
     * Show the form for editing the specified passenger_rating.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $passengerRating = $this->passengerRatingRepository->findWithoutFail($id);

        if (empty($passengerRating)) {
            Flash::error('Passenger Rating not found');

            return redirect(route('passengerRatings.index'));
        }

        return view('passenger_ratings.edit')->with('passengerRating', $passengerRating);
    }

    /**
     * Update the specified passenger_rating in storage.
     *
     * @param  int              $id
     * @param Updatepassenger_ratingRequest $request
     *
     * @return Response
     */
    public function update($id, Updatepassenger_ratingRequest $request)
    {
        $passengerRating = $this->passengerRatingRepository->findWithoutFail($id);

        if (empty($passengerRating)) {
            Flash::error('Passenger Rating not found');

            return redirect(route('passengerRatings.index'));
        }

        $passengerRating = $this->passengerRatingRepository->update($request->all(), $id);

        Flash::success('Passenger Rating updated successfully.');

        return redirect(route('passengerRatings.index'));
    }

    /**
     * Remove the specified passenger_rating from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $passengerRating = $this->passengerRatingRepository->findWithoutFail($id);

        if (empty($passengerRating)) {
            Flash::error('Passenger Rating not found');

            return redirect(route('passengerRatings.index'));
        }

        $this->passengerRatingRepository->delete($id);

        Flash::success('Passenger Rating deleted successfully.');

        return redirect(route('passengerRatings.index'));
    }
}
