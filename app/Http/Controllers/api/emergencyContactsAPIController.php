<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateemergencyContactsAPIRequest;
use App\Http\Requests\API\UpdateemergencyContactsAPIRequest;
use App\Models\emergencyContacts;
use App\Repositories\emergencyContactsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class emergencyContactsController
 * @package App\Http\Controllers\API
 */

class emergencyContactsAPIController extends AppBaseController
{
    /** @var  emergencyContactsRepository */
    private $emergencyContactsRepository;

    public function __construct(emergencyContactsRepository $emergencyContactsRepo)
    {
        $this->emergencyContactsRepository = $emergencyContactsRepo;
    }

    /**
     * Display a listing of the emergencyContacts.
     * GET|HEAD /emergencyContacts
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->emergencyContactsRepository->pushCriteria(new RequestCriteria($request));
        $this->emergencyContactsRepository->pushCriteria(new LimitOffsetCriteria($request));
        $emergencyContacts = $this->emergencyContactsRepository->all();

        return $this->sendResponse($emergencyContacts->toArray(), 'Emergency Contacts retrieved successfully');
    }

    /**
     * Store a newly created emergencyContacts in storage.
     * POST /emergencyContacts
     *
     * @param CreateemergencyContactsAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateemergencyContactsAPIRequest $request)
    {
        $input = $request->all();

        $emergencyContacts = $this->emergencyContactsRepository->create($input);

        return $this->sendResponse($emergencyContacts->toArray(), 'Emergency Contacts saved successfully');
    }

    /**
     * Display the specified emergencyContacts.
     * GET|HEAD /emergencyContacts/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var emergencyContacts $emergencyContacts */
        $emergencyContacts = $this->emergencyContactsRepository->findWithoutFail($id);

        if (empty($emergencyContacts)) {
            return $this->sendError('Emergency Contacts not found');
        }

        return $this->sendResponse($emergencyContacts->toArray(), 'Emergency Contacts retrieved successfully');
    }

    /**
     * Update the specified emergencyContacts in storage.
     * PUT/PATCH /emergencyContacts/{id}
     *
     * @param  int $id
     * @param UpdateemergencyContactsAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateemergencyContactsAPIRequest $request)
    {
        $input = $request->all();

        /** @var emergencyContacts $emergencyContacts */
        $emergencyContacts = $this->emergencyContactsRepository->findWithoutFail($id);

        if (empty($emergencyContacts)) {
            return $this->sendError('Emergency Contacts not found');
        }

        $emergencyContacts = $this->emergencyContactsRepository->update($input, $id);

        return $this->sendResponse($emergencyContacts->toArray(), 'emergencyContacts updated successfully');
    }

    /**
     * Remove the specified emergencyContacts from storage.
     * DELETE /emergencyContacts/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var emergencyContacts $emergencyContacts */
        $emergencyContacts = $this->emergencyContactsRepository->findWithoutFail($id);

        if (empty($emergencyContacts)) {
            return $this->sendError('Emergency Contacts not found');
        }

        $emergencyContacts->delete();

        return $this->sendResponse($id, 'Emergency Contacts deleted successfully');
    }
}
