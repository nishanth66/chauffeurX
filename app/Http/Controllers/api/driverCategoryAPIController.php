<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatedriverCategoryAPIRequest;
use App\Http\Requests\API\UpdatedriverCategoryAPIRequest;
use App\Models\driverCategory;
use App\Repositories\driverCategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class driverCategoryController
 * @package App\Http\Controllers\API
 */

class driverCategoryAPIController extends AppBaseController
{
    /** @var  driverCategoryRepository */
    private $driverCategoryRepository;

    public function __construct(driverCategoryRepository $driverCategoryRepo)
    {
        $this->driverCategoryRepository = $driverCategoryRepo;
    }

    /**
     * Display a listing of the driverCategory.
     * GET|HEAD /driverCategories
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->driverCategoryRepository->pushCriteria(new RequestCriteria($request));
        $this->driverCategoryRepository->pushCriteria(new LimitOffsetCriteria($request));
        $driverCategories = $this->driverCategoryRepository->all();

        return $this->sendResponse($driverCategories->toArray(), 'Driver Categories retrieved successfully');
    }

    /**
     * Store a newly created driverCategory in storage.
     * POST /driverCategories
     *
     * @param CreatedriverCategoryAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatedriverCategoryAPIRequest $request)
    {
        $input = $request->all();

        $driverCategories = $this->driverCategoryRepository->create($input);

        return $this->sendResponse($driverCategories->toArray(), 'Driver Category saved successfully');
    }

    /**
     * Display the specified driverCategory.
     * GET|HEAD /driverCategories/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var driverCategory $driverCategory */
        $driverCategory = $this->driverCategoryRepository->findWithoutFail($id);

        if (empty($driverCategory)) {
            return $this->sendError('Driver Category not found');
        }

        return $this->sendResponse($driverCategory->toArray(), 'Driver Category retrieved successfully');
    }

    /**
     * Update the specified driverCategory in storage.
     * PUT/PATCH /driverCategories/{id}
     *
     * @param  int $id
     * @param UpdatedriverCategoryAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatedriverCategoryAPIRequest $request)
    {
        $input = $request->all();

        /** @var driverCategory $driverCategory */
        $driverCategory = $this->driverCategoryRepository->findWithoutFail($id);

        if (empty($driverCategory)) {
            return $this->sendError('Driver Category not found');
        }

        $driverCategory = $this->driverCategoryRepository->update($input, $id);

        return $this->sendResponse($driverCategory->toArray(), 'driverCategory updated successfully');
    }

    /**
     * Remove the specified driverCategory from storage.
     * DELETE /driverCategories/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var driverCategory $driverCategory */
        $driverCategory = $this->driverCategoryRepository->findWithoutFail($id);

        if (empty($driverCategory)) {
            return $this->sendError('Driver Category not found');
        }

        $driverCategory->delete();

        return $this->sendResponse($id, 'Driver Category deleted successfully');
    }
}
