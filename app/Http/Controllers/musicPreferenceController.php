<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatemusicPreferenceRequest;
use App\Http\Requests\UpdatemusicPreferenceRequest;
use App\Repositories\musicPreferenceRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class musicPreferenceController extends Controller
{
    /** @var  musicPreferenceRepository */
    private $musicPreferenceRepository;

    public function __construct(musicPreferenceRepository $musicPreferenceRepo)
    {
        $this->musicPreferenceRepository = $musicPreferenceRepo;
    }

    /**
     * Display a listing of the musicPreference.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->musicPreferenceRepository->pushCriteria(new RequestCriteria($request));
        $musicPreferences = $this->musicPreferenceRepository->all();

        return view('music_preferences.index')
            ->with('musicPreferences', $musicPreferences);
    }

    /**
     * Show the form for creating a new musicPreference.
     *
     * @return Response
     */
    public function create()
    {
        return view('music_preferences.create');
    }

    /**
     * Store a newly created musicPreference in storage.
     *
     * @param CreatemusicPreferenceRequest $request
     *
     * @return Response
     */
    public function store(CreatemusicPreferenceRequest $request)
    {
        $input = $request->all();

        $musicPreference = $this->musicPreferenceRepository->create($input);

        Flash::success('Music Preference saved successfully.');

        return redirect(route('musicPreferences.index'));
    }

    /**
     * Display the specified musicPreference.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $musicPreference = $this->musicPreferenceRepository->findWithoutFail($id);

        if (empty($musicPreference)) {
            Flash::error('Music Preference not found');

            return redirect(route('musicPreferences.index'));
        }

        return view('music_preferences.show')->with('musicPreference', $musicPreference);
    }

    /**
     * Show the form for editing the specified musicPreference.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $musicPreference = $this->musicPreferenceRepository->findWithoutFail($id);

        if (empty($musicPreference)) {
            Flash::error('Music Preference not found');

            return redirect(route('musicPreferences.index'));
        }

        return view('music_preferences.edit')->with('musicPreference', $musicPreference);
    }

    /**
     * Update the specified musicPreference in storage.
     *
     * @param  int              $id
     * @param UpdatemusicPreferenceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatemusicPreferenceRequest $request)
    {
        $musicPreference = $this->musicPreferenceRepository->findWithoutFail($id);

        if (empty($musicPreference)) {
            Flash::error('Music Preference not found');

            return redirect(route('musicPreferences.index'));
        }

        $musicPreference = $this->musicPreferenceRepository->update($request->all(), $id);

        Flash::success('Music Preference updated successfully.');

        return redirect(route('musicPreferences.index'));
    }

    /**
     * Remove the specified musicPreference from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $musicPreference = $this->musicPreferenceRepository->findWithoutFail($id);

        if (empty($musicPreference)) {
            Flash::error('Music Preference not found');

            return redirect(route('musicPreferences.index'));
        }

        $this->musicPreferenceRepository->delete($id);

        Flash::success('Music Preference deleted successfully.');

        return redirect(route('musicPreferences.index'));
    }
}
