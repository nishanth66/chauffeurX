<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateinvitedFriendsRequest;
use App\Http\Requests\UpdateinvitedFriendsRequest;
use App\Repositories\invitedFriendsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class invitedFriendsController extends AppBaseController
{
    /** @var  invitedFriendsRepository */
    private $invitedFriendsRepository;

    public function __construct(invitedFriendsRepository $invitedFriendsRepo)
    {
        $this->invitedFriendsRepository = $invitedFriendsRepo;
    }

    /**
     * Display a listing of the invitedFriends.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->invitedFriendsRepository->pushCriteria(new RequestCriteria($request));
        $invitedFriends = $this->invitedFriendsRepository->all();

        return view('invited_friends.index')
            ->with('invitedFriends', $invitedFriends);
    }

    /**
     * Show the form for creating a new invitedFriends.
     *
     * @return Response
     */
    public function create()
    {
        return view('invited_friends.create');
    }

    /**
     * Store a newly created invitedFriends in storage.
     *
     * @param CreateinvitedFriendsRequest $request
     *
     * @return Response
     */
    public function store(CreateinvitedFriendsRequest $request)
    {
        $input = $request->all();

        $invitedFriends = $this->invitedFriendsRepository->create($input);

        Flash::success('Invited Friends saved successfully.');

        return redirect(route('invitedFriends.index'));
    }

    /**
     * Display the specified invitedFriends.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $invitedFriends = $this->invitedFriendsRepository->findWithoutFail($id);

        if (empty($invitedFriends)) {
            Flash::error('Invited Friends not found');

            return redirect(route('invitedFriends.index'));
        }

        return view('invited_friends.show')->with('invitedFriends', $invitedFriends);
    }

    /**
     * Show the form for editing the specified invitedFriends.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $invitedFriends = $this->invitedFriendsRepository->findWithoutFail($id);

        if (empty($invitedFriends)) {
            Flash::error('Invited Friends not found');

            return redirect(route('invitedFriends.index'));
        }

        return view('invited_friends.edit')->with('invitedFriends', $invitedFriends);
    }

    /**
     * Update the specified invitedFriends in storage.
     *
     * @param  int              $id
     * @param UpdateinvitedFriendsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateinvitedFriendsRequest $request)
    {
        $invitedFriends = $this->invitedFriendsRepository->findWithoutFail($id);

        if (empty($invitedFriends)) {
            Flash::error('Invited Friends not found');

            return redirect(route('invitedFriends.index'));
        }

        $invitedFriends = $this->invitedFriendsRepository->update($request->all(), $id);

        Flash::success('Invited Friends updated successfully.');

        return redirect(route('invitedFriends.index'));
    }

    /**
     * Remove the specified invitedFriends from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $invitedFriends = $this->invitedFriendsRepository->findWithoutFail($id);

        if (empty($invitedFriends)) {
            Flash::error('Invited Friends not found');

            return redirect(route('invitedFriends.index'));
        }

        $this->invitedFriendsRepository->delete($id);

        Flash::success('Invited Friends deleted successfully.');

        return redirect(route('invitedFriends.index'));
    }
}
