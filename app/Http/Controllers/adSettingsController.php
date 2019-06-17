<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateadSettingsRequest;
use App\Http\Requests\UpdateadSettingsRequest;
use App\Models\adSettings;
use App\Models\availableCities;
use App\Repositories\adSettingsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class adSettingsController extends Controller
{
    /** @var  adSettingsRepository */
    private $adSettingsRepository;

    public function __construct(adSettingsRepository $adSettingsRepo)
    {
        $this->adSettingsRepository = $adSettingsRepo;
    }

    /**
     * Display a listing of the adSettings.
     *
     * @param Request $request
     * @return Response
     */
    public function index()
    {
        if (Auth::user()->status == 0)
        {
            if ($message = Session::get('adSettings'))
            {
                if ($message == 'all')
                {
                    $adSettings = adSettings::get();
                }
                else
                {
                    $adSettings = adSettings::where('city','like',$message)->get();
                }
            }
            else
            {
                $adSettings = adSettings::get();

            }
            $cities = availableCities::get();
            return view('ad_settings.index',compact('adSettings','cities'));
        }
        else
        {
            return view('errors.404');
        }
    }

    /**
     * Show the form for creating a new adSettings.
     *
     * @return Response
     */
    public function create()
    {
        $cities = availableCities::get();
        return view('ad_settings.create',compact('cities'));
    }

    /**
     * Store a newly created adSettings in storage.
     *
     * @param CreateadSettingsRequest $request
     *
     * @return Response
     */
    public function store(CreateadSettingsRequest $request)
    {
        $input = $request->all();
        if ($input['view_cost'] == null)
        {
            $input['view_cost'] = 0;
        }
        if ($input['category_view_cost'] == null)
        {
            $input['category_view_cost'] = 0;
        }
        if ($input['max_distance'] == null)
        {
            $input['max_distance'] = 0;
        }

        if (adSettings::where('city',$request->city)->exists())
        {
            Flash::error("The entry is already Exists! Please try editing it");
            return redirect(route('adSettings.index'));
        }
        $adSettings = $this->adSettingsRepository->create($input);

        Flash::success('Ad Settings saved successfully.');

        return redirect(route('adSettings.index'));
    }

    /**
     * Display the specified adSettings.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $adSettings = $this->adSettingsRepository->findWithoutFail($id);
        if (empty($adSettings)) {
            Flash::error('Ad Settings not found');

            return redirect(route('adSettings.index'));
        }

        return view('ad_settings.show')->with('adSettings', $adSettings);
    }

    /**
     * Show the form for editing the specified adSettings.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $adSettings = $this->adSettingsRepository->findWithoutFail($id);
        $cities = availableCities::get();
        if (empty($adSettings)) {
            Flash::error('Ad Settings not found');

            return redirect(route('adSettings.index'));
        }

        return view('ad_settings.edit',compact('adSettings','cities'));
    }

    /**
     * Update the specified adSettings in storage.
     *
     * @param  int              $id
     * @param UpdateadSettingsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateadSettingsRequest $request)
    {
        $adSettings = $this->adSettingsRepository->findWithoutFail($id);

        if (empty($adSettings)) {
            Flash::error('Ad Settings not found');

            return redirect(route('adSettings.index'));
        }
        if (adSettings::where('city',$request->city)->where('id','!=',$id)->exists())
        {
            Flash::error("The entry is already Exists! Please try editing it");
            return redirect(route('adSettings.index'));
        }
        $adSettings = $this->adSettingsRepository->update($request->all(), $id);

        Flash::success('Ad Settings updated successfully.');

        return redirect(route('adSettings.index'));
    }

    /**
     * Remove the specified adSettings from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $adSettings = $this->adSettingsRepository->findWithoutFail($id);

        if (empty($adSettings)) {
            Flash::error('Ad Settings not found');

            return redirect(route('adSettings.index'));
        }

        $this->adSettingsRepository->delete($id);

        Flash::success('Ad Settings deleted successfully.');

        return redirect(route('adSettings.index'));
    }
    public function changeCity($city)
    {
        Session::put('adSettings',$city);
        return 1;
    }
}
