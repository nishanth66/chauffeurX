<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatedriverBasicDetailsAPIRequest;
use App\Http\Requests\API\UpdatedriverBasicDetailsAPIRequest;
use App\Models\driverBasicDetails;
use App\Repositories\driverBasicDetailsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class driverBasicDetailsController
 * @package App\Http\Controllers\API
 */

class driverBasicDetailsAPIController extends AppBaseController
{
    /** @var  driverBasicDetailsRepository */
    private $driverBasicDetailsRepository;

    public function __construct(driverBasicDetailsRepository $driverBasicDetailsRepo)
    {
        $this->driverBasicDetailsRepository = $driverBasicDetailsRepo;
    }

    /**
     * Display a listing of the driverBasicDetails.
     * GET|HEAD /driverBasicDetails
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->driverBasicDetailsRepository->pushCriteria(new RequestCriteria($request));
        $this->driverBasicDetailsRepository->pushCriteria(new LimitOffsetCriteria($request));
        $driverBasicDetails = $this->driverBasicDetailsRepository->all();

        return $this->sendResponse($driverBasicDetails->toArray(), 'Driver Basic Details retrieved successfully');
    }

    /**
     * Store a newly created driverBasicDetails in storage.
     * POST /driverBasicDetails
     *
     * @param CreatedriverBasicDetailsAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatedriverBasicDetailsAPIRequest $request)
    {
        $input = $request->all();

        $driverBasicDetails = $this->driverBasicDetailsRepository->create($input);

        return $this->sendResponse($driverBasicDetails->toArray(), 'Driver Basic Details saved successfully');
    }

    /**
     * Display the specified driverBasicDetails.
     * GET|HEAD /driverBasicDetails/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var driverBasicDetails $driverBasicDetails */
        $driverBasicDetails = $this->driverBasicDetailsRepository->findWithoutFail($id);

        if (empty($driverBasicDetails)) {
            return $this->sendError('Driver Basic Details not found');
        }

        return $this->sendResponse($driverBasicDetails->toArray(), 'Driver Basic Details retrieved successfully');
    }

    /**
     * Update the specified driverBasicDetails in storage.
     * PUT/PATCH /driverBasicDetails/{id}
     *
     * @param  int $id
     * @param UpdatedriverBasicDetailsAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatedriverBasicDetailsAPIRequest $request)
    {
        $input = $request->all();

        /** @var driverBasicDetails $driverBasicDetails */
        $driverBasicDetails = $this->driverBasicDetailsRepository->findWithoutFail($id);

        if (empty($driverBasicDetails)) {
            return $this->sendError('Driver Basic Details not found');
        }

        $driverBasicDetails = $this->driverBasicDetailsRepository->update($input, $id);

        return $this->sendResponse($driverBasicDetails->toArray(), 'driverBasicDetails updated successfully');
    }

    /**
     * Remove the specified driverBasicDetails from storage.
     * DELETE /driverBasicDetails/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var driverBasicDetails $driverBasicDetails */
        $driverBasicDetails = $this->driverBasicDetailsRepository->findWithoutFail($id);

        if (empty($driverBasicDetails)) {
            return $this->sendError('Driver Basic Details not found');
        }

        $driverBasicDetails->delete();

        return $this->sendResponse($id, 'Driver Basic Details deleted successfully');
    }
}
