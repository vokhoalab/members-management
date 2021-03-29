<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiOperationFailedException;
use App\Http\Controllers\BaseController;
use App\Http\Requests\API\CreateMemberRequest;
use App\Http\Requests\API\UpdateMemberRequest;
use App\Models\Member;
use App\Repositories\Contracts\MemberRepositoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class MemberController
 */
class MemberController extends BaseController
{
    /** @var  MemberRepositoryInterface */
    private $memberRepository;

    public function __construct(MemberRepositoryInterface $memberRepo)
    {
        $this->memberRepository = $memberRepo;
    }

    /**
     * Display a listing of the member.
     * GET|HEAD /members
     *
     * @param  Request  $request
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $input = $request->except(['skip', 'limit']);
        $members = $this->memberRepository->all(
            $input,
            $request->get('skip'),
            $request->get('limit')
        );

        $input['withCount'] = 1;

        return $this->sendResponse(
            $members->toArray(),
            'Members retrieved successfully.',
            ['totalRecords' => $this->memberRepository->all($input)]
        );
    }

    /**
     * Store a newly created Member in storage.
     * POST /teams
     *
     * @param  CreateMemberRequest  $request
     *
     * @throws ApiOperationFailedException
     *
     * @return JsonResponse
     */
    public function store(CreateMemberRequest $request)
    {
        $input = $request->all();

        $member = $this->memberRepository->store($input);

        return $this->sendResponse($member->toArray(), 'Member saved successfully.');
    }

    /**
     * Display the specified Team.
     * GET|HEAD /teams/{id}
     *
     * @param  Member  $member
     *
     * @return JsonResponse
     */
    public function show(Member $member)
    {
        $member = Member::with('user','teams','teams.department')->findOrFail($member->id);

        return $this->sendResponse($member->toArray(), 'Member retrieved successfully.');
    }

    /**
     * Update the specified Member in storage.
     * PUT/PATCH /members/{id}
     *
     * @param  Member  $member
     * @param  UpdateTeamRequest  $request
     *
     * @throws ApiOperationFailedException
     * @return JsonResponse
     */
    public function update(Member $member, UpdateMemberRequest $request)
    {
        $input = $request->all();

        $member = $this->memberRepository->update($input, $member->id);

        return $this->sendResponse($member->toArray(), 'Member updated successfully.');
    }

    /**
     * Remove the specified Member from storage.
     * DELETE /members/{id}
     *
     * @param  Member  $member
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function destroy(Member $member)
    {        
        $member->delete();

        return $this->sendResponse($member, 'Member deleted successfully.');
    }
}
