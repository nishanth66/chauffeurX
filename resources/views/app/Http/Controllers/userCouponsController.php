<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateuserCouponsRequest;
use App\Http\Requests\UpdateuserCouponsRequest;
use App\Models\passengers;
use App\Repositories\userCouponsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class userCouponsController extends Controller
{
    /** @var  userCouponsRepository */
    private $userCouponsRepository;

    public function __construct(userCouponsRepository $userCouponsRepo)
    {
        $this->userCouponsRepository = $userCouponsRepo;
    }

    /**
     * Display a listing of the userCoupons.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->userCouponsRepository->pushCriteria(new RequestCriteria($request));
        $userCoupons = $this->userCouponsRepository->all();

        return view('user_coupons.index')
            ->with('userCoupons', $userCoupons);
    }

    /**
     * Show the form for creating a new userCoupons.
     *
     * @return Response
     */
    public function create()
    {
        $users = passengers::get();
        return view('user_coupons.create',compact('users'));
    }

    /**
     * Store a newly created userCoupons in storage.
     *
     * @param CreateuserCouponsRequest $request
     *
     * @return Response
     */
    public function store(CreateuserCouponsRequest $request)
    {
        $input = $request->all();

        $userCoupons = $this->userCouponsRepository->create($input);

        Flash::success('User Coupons saved successfully.');

        return redirect(route('userCoupons.index'));
    }

    /**
     * Display the specified userCoupons.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $userCoupons = $this->userCouponsRepository->findWithoutFail($id);

        if (empty($userCoupons)) {
            Flash::error('User Coupons not found');

            return redirect(route('userCoupons.index'));
        }

        return view('user_coupons.show')->with('userCoupons', $userCoupons);
    }

    /**
     * Show the form for editing the specified userCoupons.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $users = passengers::get();
        $userCoupons = $this->userCouponsRepository->findWithoutFail($id);

        if (empty($userCoupons)) {
            Flash::error('User Coupons not found');

            return redirect(route('userCoupons.index'));
        }

        return view('user_coupons.edit',compact('userCoupons','users'));
    }

    /**
     * Update the specified userCoupons in storage.
     *
     * @param  int              $id
     * @param UpdateuserCouponsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateuserCouponsRequest $request)
    {
        $userCoupons = $this->userCouponsRepository->findWithoutFail($id);

        if (empty($userCoupons)) {
            Flash::error('User Coupons not found');

            return redirect(route('userCoupons.index'));
        }

        $userCoupons = $this->userCouponsRepository->update($request->all(), $id);

        Flash::success('User Coupons updated successfully.');

        return redirect(route('userCoupons.index'));
    }

    /**
     * Remove the specified userCoupons from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $userCoupons = $this->userCouponsRepository->findWithoutFail($id);

        if (empty($userCoupons)) {
            Flash::error('User Coupons not found');

            return redirect(route('userCoupons.index'));
        }

        $this->userCouponsRepository->delete($id);

        Flash::success('User Coupons deleted successfully.');

        return redirect(route('userCoupons.index'));
    }
}
