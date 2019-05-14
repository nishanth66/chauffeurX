<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatecategoriesRequest;
use App\Http\Requests\UpdatecategoriesRequest;
use App\Models\availableCities;
use App\Models\categories;
use App\Repositories\categoriesRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class categoriesController extends Controller
{
    /** @var  categoriesRepository */
    private $categoriesRepository;

    public function __construct(categoriesRepository $categoriesRepo)
    {
        $this->middleware('auth');
        $this->categoriesRepository = $categoriesRepo;
    }

    /**
     * Display a listing of the categories.
     *
     * @param Request $request
     * @return Response
     */
    public function index()
    {
        if (Auth::user()->status == 0)
        {
            if ($message = Session::get('categoryCity'))
            {
                if ($message == 'all')
                {
                    $categories = categories::get();
                }
                else
                {
                    $categories = categories::where('city','like',$message)->get();
                }
            }
            else
            {
                $categories = categories::get();

            }
            $cities = availableCities::get();
            return view('categories.index',compact('categories','cities'));
        }
        else
        {
            return view('errors.404');
        }
    }

    /**
     * Show the form for creating a new categories.
     *
     * @return Response
     */
    public function create()
    {
        $cities = availableCities::get();
        return view('categories.create',compact('cities'));
    }

    /**
     * Store a newly created categories in storage.
     *
     * @param CreatecategoriesRequest $request
     *
     * @return Response
     */
    public function store(CreatecategoriesRequest $request)
    {
        if (categories::where('city',$request->city)->where('name',$request->name)->exists())
        {
            Flash::error("The entry is already Exists! Please try editing it");
            return redirect(route('categories.index'));
        }
        $input = $request->except('image');
        if ($request->hasFile('image'))
        {
            $photoName = rand(1,7257361) . time() . '.' . $request->image->getClientOriginalExtension();
            $mime = $request->image->getClientOriginalExtension();
            $request->image->move(public_path('avatars'), $photoName);
            $input['image'] = $photoName;
        }

        $categories = $this->categoriesRepository->create($input);

        Flash::success('Categories saved successfully.');

        return redirect(route('categories.index'));
    }

    /**
     * Display the specified categories.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $categories = $this->categoriesRepository->findWithoutFail($id);

        if (empty($categories)) {
            Flash::error('Categories not found');

            return redirect(route('categories.index'));
        }

        return view('categories.show')->with('categories', $categories);
    }

    /**
     * Show the form for editing the specified categories.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $categories = $this->categoriesRepository->findWithoutFail($id);
        $cities = availableCities::get();
        if (empty($categories)) {
            Flash::error('Categories not found');

            return redirect(route('categories.index'));
        }

        return view('categories.edit',compact('categories','cities'));
    }

    /**
     * Update the specified categories in storage.
     *
     * @param  int              $id
     * @param UpdatecategoriesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatecategoriesRequest $request)
    {
        $categories = $this->categoriesRepository->findWithoutFail($id);

        if (empty($categories)) {
            Flash::error('Categories not found');

            return redirect(route('categories.index'));
        }
        $input = $request->except('image');
        if ($request->hasFile('image'))
        {
            $photoName = rand(1,7257361) . time() . '.' . $request->image->getClientOriginalExtension();
            $mime = $request->image->getClientOriginalExtension();
            $request->image->move(public_path('avatars'), $photoName);
            $input['image'] = $photoName;
        }
        if (categories::where('city',$request->city)->where('name',$request->name)->where('id','!=',$id)->exists())
        {
            Flash::error("The entry is already Exists! Please try editing it");
            return redirect(route('categories.index'));
        }
        $categories = $this->categoriesRepository->update($input, $id);

        Flash::success('Categories updated successfully.');

        return redirect(route('categories.index'));
    }

    /**
     * Remove the specified categories from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $categories = $this->categoriesRepository->findWithoutFail($id);

        if (empty($categories)) {
            Flash::error('Categories not found');

            return redirect(route('categories.index'));
        }

        categories::whereId($id)->forcedelete();

        Flash::success('Categories deleted successfully.');

        return redirect(route('categories.index'));
    }

    public function changeCity($city)
    {
        Session::put('categoryCity',$city);
        if ($city == 'all')
        {
            $categories = categories::get();
        }
        else
        {
            $categories = categories::where('city','like',$city)->get();
        }
        $result = $this->getCategoryTable($categories);
        return $result;
    }

    public function getCategoryTable($categories)
    {
        $html = <<<EOD
        <!--<table class="table table-responsive" id="drivers-table">-->
            <thead>
                <tr>
                    <th>City</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
EOD;
        foreach ($categories as $category) {
            if (isset($category->image) && $category->image != '' || $category->image != null) {
                $imageLink = asset('public/avatars') . '/' . $category->image;
            } else {
                $imageLink = asset('public/image/default.png');
            }
            $editUrl = route('categories.edit', $category->id);
            $formUrl = url('category/delete') . '/' . $category->id;
            $html .= <<<EOD
                <tr>
                    <td>$category->city</td>
                    <td>$category->name</td>
                    <td><img src="$imageLink" class="show-image"></td>
                    <td>
                            <div class='btn-group'>
                                <a href="$editUrl" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                                <a href="$formUrl" class="btn btn-danger btn-xs" onclick="return confirm('Are you Sure?')"><i class="glyphicon glyphicon-trash"></i></a>
                            </div>
                    </td>
                </tr>
EOD;
        }
        return $html;
    }
    public function delete($id)
    {
        categories::whereId($id)->forcedelete();
        Flash::success("Driver Deleted Successfully");
        return redirect(route('categories.index'));
    }
}
