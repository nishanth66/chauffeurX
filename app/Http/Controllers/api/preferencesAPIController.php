<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatepreferencesAPIRequest;
use App\Http\Requests\API\UpdatepreferencesAPIRequest;
use App\Models\preferences;
use App\Repositories\preferencesRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class preferencesController
 * @package App\Http\Controllers\API
 */

class preferencesAPIController extends AppBaseController
{
    /** @var  preferencesRepository */
    private $preferencesRepository;

    public function __construct(preferencesRepository $preferencesRepo)
    {
        $this->preferencesRepository = $preferencesRepo;
    }

    /**
     * Display a listing of the preferences.
     * GET|HEAD /preferences
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->preferencesRepository->pushCriteria(new RequestCriteria($request));
        $this->preferencesRepository->pushCriteria(new LimitOffsetCriteria($request));
        $preferences = $this->preferencesRepository->all();

        return $this->sendResponse($preferences->toArray(), 'Preferences retrieved successfully');
    }

    /**
     * Store a newly created preferences in storage.
     * POST /preferences
     *
     * @param CreatepreferencesAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatepreferencesAPIRequest $request)
    {
        $input = $request->all();

        $preferences = $this->preferencesRepository->create($input);

        return $this->sendResponse($preferences->toArray(), 'Preferences saved successfully');
    }

    /**
     * Display the specified preferences.
     * GET|HEAD /preferences/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var preferences $preferences */
        $preferences = $this->preferencesRepository->findWithoutFail($id);

        if (empty($preferences)) {
            return $this->sendError('Preferences not found');
        }

        return $this->sendResponse($preferences->toArray(), 'Preferences retrieved successfully');
    }

    /**
     * Update the specified preferences in storage.
     * PUT/PATCH /preferences/{id}
     *
     * @param  int $id
     * @param UpdatepreferencesAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatepreferencesAPIRequest $request)
    {
        $input = $request->all();

        /** @var preferences $preferences */
        $preferences = $this->preferencesRepository->findWithoutFail($id);

        if (empty($preferences)) {
            return $this->sendError('Preferences not found');
        }

        $preferences = $this->preferencesRepository->update($input, $id);

        return $this->sendResponse($preferences->toArray(), 'preferences updated successfully');
    }

    /**
     * Remove the specified preferences from storage.
     * DELETE /preferences/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var preferences $preferences */
        $preferences = $this->preferencesRepository->findWithoutFail($id);

        if (empty($preferences)) {
            return $this->sendError('Preferences not found');
        }

        $preferences->delete();

        return $this->sendResponse($id, 'Preferences deleted successfully');
    }
}
