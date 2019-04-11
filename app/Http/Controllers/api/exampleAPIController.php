<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateexampleAPIRequest;
use App\Http\Requests\API\UpdateexampleAPIRequest;
use App\Models\example;
use App\Repositories\exampleRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class exampleController
 * @package App\Http\Controllers\API
 */

class exampleAPIController extends AppBaseController
{
    /** @var  exampleRepository */
    private $exampleRepository;

    public function __construct(exampleRepository $exampleRepo)
    {
        $this->exampleRepository = $exampleRepo;
    }

    /**
     * Display a listing of the example.
     * GET|HEAD /examples
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->exampleRepository->pushCriteria(new RequestCriteria($request));
        $this->exampleRepository->pushCriteria(new LimitOffsetCriteria($request));
        $examples = $this->exampleRepository->all();

        return $this->sendResponse($examples->toArray(), 'Examples retrieved successfully');
    }

    /**
     * Store a newly created example in storage.
     * POST /examples
     *
     * @param CreateexampleAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateexampleAPIRequest $request)
    {
        $input = $request->all();

        $examples = $this->exampleRepository->create($input);

        return $this->sendResponse($examples->toArray(), 'Example saved successfully');
    }

    /**
     * Display the specified example.
     * GET|HEAD /examples/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var example $example */
        $example = $this->exampleRepository->findWithoutFail($id);

        if (empty($example)) {
            return $this->sendError('Example not found');
        }

        return $this->sendResponse($example->toArray(), 'Example retrieved successfully');
    }

    /**
     * Update the specified example in storage.
     * PUT/PATCH /examples/{id}
     *
     * @param  int $id
     * @param UpdateexampleAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateexampleAPIRequest $request)
    {
        $input = $request->all();

        /** @var example $example */
        $example = $this->exampleRepository->findWithoutFail($id);

        if (empty($example)) {
            return $this->sendError('Example not found');
        }

        $example = $this->exampleRepository->update($input, $id);

        return $this->sendResponse($example->toArray(), 'example updated successfully');
    }

    /**
     * Remove the specified example from storage.
     * DELETE /examples/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var example $example */
        $example = $this->exampleRepository->findWithoutFail($id);

        if (empty($example)) {
            return $this->sendError('Example not found');
        }

        $example->delete();

        return $this->sendResponse($id, 'Example deleted successfully');
    }
}
