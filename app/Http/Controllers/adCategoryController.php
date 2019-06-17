<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateadCategoryRequest;
use App\Http\Requests\UpdateadCategoryRequest;
use App\Models\adCategory;
use App\Models\availableCities;
use App\Repositories\adCategoryRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class adCategoryController extends Controller
{
    /** @var  adCategoryRepository */
    private $adCategoryRepository;

    public function __construct(adCategoryRepository $adCategoryRepo)
    {
        $this->adCategoryRepository = $adCategoryRepo;
    }

    /**
     * Display a listing of the adCategory.
     *
     * @param Request $request
     * @return Response
     */
    public function index()
    {
        if (Auth::user()->status == 0)
        {
            if ($message = Session::get('adCategory'))
            {
                if ($message == 'all')
                {
                    $adCategories = adCategory::get();
                }
                else
                {
                    $adCategories = adCategory::where('city','like',$message)->get();
                }
            }
            else
            {
                $adCategories = adCategory::get();

            }
            $cities = availableCities::get();
            return view('ad_categories.index',compact('adCategories','cities'));
        }
        else
        {
            return view('errors.404');
        }
    }

    /**
     * Show the form for creating a new adCategory.
     *
     * @return Response
     */
    public function create()
    {
        $cities = availableCities::get();
        return view('ad_categories.create',compact('cities'));
    }

    /**
     * Store a newly created adCategory in storage.
     *
     * @param CreateadCategoryRequest $request
     *
     * @return Response
     */
    public function store(CreateadCategoryRequest $request)
    {
        $input = $request->all();
        if (adCategory::where('city',$request->city)->where('name',$request->name)->exists())
        {
            Flash::error("Entry is already exists");
            return redirect(route('adCategories.index'));
        }
        $adCategory = $this->adCategoryRepository->create($input);

        Flash::success('Ad Category saved successfully.');

        return redirect(route('adCategories.index'));
    }

    /**
     * Display the specified adCategory.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $adCategory = $this->adCategoryRepository->findWithoutFail($id);

        if (empty($adCategory)) {
            Flash::error('Ad Category not found');

            return redirect(route('adCategories.index'));
        }

        return view('ad_categories.show')->with('adCategory', $adCategory);
    }

    /**
     * Show the form for editing the specified adCategory.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $adCategory = $this->adCategoryRepository->findWithoutFail($id);
        $cities = availableCities::get();
        if (empty($adCategory)) {
            Flash::error('Ad Category not found');

            return redirect(route('adCategories.index'));
        }
        return view('ad_categories.edit',compact('adCategory','cities'));
    }

    /**
     * Update the specified adCategory in storage.
     *
     * @param  int              $id
     * @param UpdateadCategoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateadCategoryRequest $request)
    {
        $adCategory = $this->adCategoryRepository->findWithoutFail($id);
        if (adCategory::where('city',$request->city)->where('name',$request->name)->where('id','!=',$id)->exists())
        {
            Flash::error("Entry is already exists");
            return redirect(route('adCategories.index'));
        }
        if (empty($adCategory)) {
            Flash::error('Ad Category not found');

            return redirect(route('adCategories.index'));
        }

        $adCategory = $this->adCategoryRepository->update($request->all(), $id);

        Flash::success('Ad Category updated successfully.');

        return redirect(route('adCategories.index'));
    }

    /**
     * Remove the specified adCategory from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $adCategory = $this->adCategoryRepository->findWithoutFail($id);

        if (empty($adCategory)) {
            Flash::error('Ad Category not found');

            return redirect(route('adCategories.index'));
        }

        $this->adCategoryRepository->delete($id);

        Flash::success('Ad Category deleted successfully.');

        return redirect(route('adCategories.index'));
    }
    public function changeAdCatCity ($city)
    {
        Session::put('adCategory',$city);
        return 1;
    }
}
