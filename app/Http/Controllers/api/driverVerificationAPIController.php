<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatedriverVerificationAPIRequest;
use App\Http\Requests\API\UpdatedriverVerificationAPIRequest;
use App\Models\driverVerification;
use App\Repositories\driverVerificationRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class driverVerificationController
 * @package App\Http\Controllers\API
 */

class driverVerificationAPIController extends AppBaseController
{
    /** @var  driverVerificationRepository */
    private $driverVerificationRepository;

    public function __construct(driverVerificationRepository $driverVerificationRepo)
    {
        $this->driverVerificationRepository = $driverVerificationRepo;
    }

    /**
     * Display a listing of the driverVerification.
     * GET|HEAD /driverVerifications
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->driverVerificationRepository->pushCriteria(new RequestCriteria($request));
        $this->driverVerificationRepository->pushCriteria(new LimitOffsetCriteria($request));
        $driverVerifications = $this->driverVerificationRepository->all();

        return $this->sendResponse($driverVerifications->toArray(), 'Driver Verifications retrieved successfully');
    }

    /**
     * Store a newly created driverVerification in storage.
     * POST /driverVerifications
     *
     * @param CreatedriverVerificationAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatedriverVerificationAPIRequest $request)
    {
        $input = $request->all();

        $driverVerifications = $this->driverVerificationRepository->create($input);

        return $this->sendResponse($driverVerifications->toArray(), 'Driver Verification saved successfully');
    }

    /**
     * Display the specified driverVerification.
     * GET|HEAD /driverVerifications/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var driverVerification $driverVerification */
        $driverVerification = $this->driverVerificationRepository->findWithoutFail($id);

        if (empty($driverVerification)) {
            return $this->sendError('Driver Verification not found');
        }

        return $this->sendResponse($driverVerification->toArray(), 'Driver Verification retrieved successfully');
    }

    /**
     * Update the specified driverVerification in storage.
     * PUT/PATCH /driverVerifications/{id}
     *
     * @param  int $id
     * @param UpdatedriverVerificationAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatedriverVerificationAPIRequest $request)
    {
        $input = $request->all();

        /** @var driverVerification $driverVerification */
        $driverVerification = $this->driverVerificationRepository->findWithoutFail($id);

        if (empty($driverVerification)) {
            return $this->sendError('Driver Verification not found');
        }

        $driverVerification = $this->driverVerificationRepository->update($input, $id);

        return $this->sendResponse($driverVerification->toArray(), 'driverVerification updated successfully');
    }

    /**
     * Remove the specified driverVerification from storage.
     * DELETE /driverVerifications/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var driverVerification $driverVerification */
        $driverVerification = $this->driverVerificationRepository->findWithoutFail($id);

        if (empty($driverVerification)) {
            return $this->sendError('Driver Verification not found');
        }

        $driverVerification->delete();

        return $this->sendResponse($id, 'Driver Verification deleted successfully');
    }
}
