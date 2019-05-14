<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatepriceRequest;
use App\Http\Requests\UpdatepriceRequest;
use App\Models\availableCities;
use App\Models\categories;
use App\Models\price;
use App\Repositories\priceRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class priceController extends Controller
{
    /** @var  priceRepository */
    private $priceRepository;

    public function __construct(priceRepository $priceRepo)
    {
        $this->middleware('auth');
        $this->priceRepository = $priceRepo;
    }

    /**
     * Display a listing of the price.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $categories = categories::get();
        $this->priceRepository->pushCriteria(new RequestCriteria($request));
        $prices = $this->priceRepository->all();


        return view('prices.index',compact('categories','prices'));
    }

    /**
     * Show the form for creating a new price.
     *
     * @return Response
     */
    public function create()
    {
        $categories = categories::get();
        $cities = availableCities::get();
        return view('prices.create',compact('categories','cities'));
    }

    /**
     * Store a newly created price in storage.
     *
     * @param CreatepriceRequest $request
     *
     * @return Response
     */
    public function store(CreatepriceRequest $request)
    {
        $input = $request->all();

        if (price::where('city',$request->city)->where('category',$request->category)->exists())
        {
            Flash::error("Entry already exists! Please try editing it");
            return redirect(route('prices.index'));
        }

        $price = $this->priceRepository->create($input);

        Flash::success('Price saved successfully.');

        return redirect(route('prices.index'));
    }

    /**
     * Display the specified price.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $price = $this->priceRepository->findWithoutFail($id);

        if (empty($price)) {
            Flash::error('Price not found');

            return redirect(route('prices.index'));
        }

        return view('prices.show')->with('price', $price);
    }

    /**
     * Show the form for editing the specified price.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $price = $this->priceRepository->findWithoutFail($id);
        $city = availableCities::whereId($price->city)->first();
        $categories = categories::where('city','like',$city->city)->get();
        $cities = availableCities::get();

        if (empty($price)) {
            Flash::error('Price not found');

            return redirect(route('prices.index'));
        }

        return view('prices.edit',compact('categories','price','cities'));
    }

    /**
     * Update the specified price in storage.
     *
     * @param  int              $id
     * @param UpdatepriceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatepriceRequest $request)
    {
        $price = $this->priceRepository->findWithoutFail($id);

        if (empty($price)) {
            Flash::error('Price not found');

            return redirect(route('prices.index'));
        }
        if (price::where('city',$request->city)->where('category',$request->category)->where('id','!=',$id)->exists())
        {
            Flash::error("Entry already exists! Please try editing it");
            return redirect(route('prices.index'));
        }
        $price = $this->priceRepository->update($request->all(), $id);

        Flash::success('Price updated successfully.');

        return redirect(route('prices.index'));
    }

    /**
     * Remove the specified price from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $price = $this->priceRepository->findWithoutFail($id);

        if (empty($price)) {
            Flash::error('Price not found');

            return redirect(route('prices.index'));
        }

        $this->priceRepository->delete($id);

        Flash::success('Price deleted successfully.');

        return redirect(route('prices.index'));
    }


    public function fetchCityCategory($city)
    {
        $city = availableCities::whereId($city)->first();
        $categories = categories::where('city','like',$city->city)->get();
        $html = <<<EOD
            <label>Category:</label>
            <select  name="category" class="form-control">
                <option value="" selected disabled>Select a Category</option>
EOD;
            foreach ($categories as $category)
            {
        $html .=<<<EOD
                <option value="$category->id">$category->name</option>
EOD;
            }
            return $html;

    }
}
