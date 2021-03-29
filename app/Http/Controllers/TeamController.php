<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiOperationFailedException;
use App\Http\Controllers\BaseController;
use App\Http\Requests\API\CreateTeamRequest;
use App\Http\Requests\API\UpdateTeamRequest;
use App\Models\Team;
use App\Repositories\Contracts\TeamRepositoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class TeamController
 */
class TeamController extends BaseController
{
    /** @var  TeamRepositoryInterface */
    private $teamRepository;

    public function __construct(TeamRepositoryInterface $teamRepo)
    {
        $this->teamRepository = $teamRepo;
    }

    /**
     * Display a listing of the Team.
     * GET|HEAD /teams
     *
     * @param  Request  $request
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $input = $request->except(['skip', 'limit']);
        $teams = $this->teamRepository->all(
            $input,
            $request->get('skip'),
            $request->get('limit')
        );

        $input['withCount'] = 1;

        return $this->sendResponse(
            $teams->toArray(),
            'Teams retrieved successfully.',
            ['totalRecords' => $this->teamRepository->all($input)]
        );
    }

    /**
     * Store a newly created Team in storage.
     * POST /teams
     *
     * @param  CreateTeamRequest  $request
     *
     * @throws ApiOperationFailedException
     *
     * @return JsonResponse
     */
    public function store(CreateTeamRequest $request)
    {
        $input = $request->all();

        $team = $this->teamRepository->store($input);

        return $this->sendResponse($team->toArray(), 'Team saved successfully.');
    }

    /**
     * Display the specified Team.
     * GET|HEAD /teams/{id}
     *
     * @param  Team  $team
     *
     * @return JsonResponse
     */
    public function show(Team $team)
    {
        $team = Team::findOrFail($team->id);

        return $this->sendResponse($team->toArray(), 'Team retrieved successfully.');
    }

    /**
     * Update the specified Team in storage.
     * PUT/PATCH /teams/{id}
     *
     * @param  Team  $team
     * @param  UpdateTeamRequest  $request
     *
     * @throws ApiOperationFailedException
     * @return JsonResponse
     */
    public function update(Team $team, UpdateTeamRequest $request)
    {
        $input = $request->all();

        $team = $this->teamRepository->update($input, $team->id);

        return $this->sendResponse($team->toArray(), 'Team updated successfully.');
    }

    /**
     * Remove the specified Team from storage.
     * DELETE /teams/{id}
     *
     * @param  Team  $team
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function destroy(Team $team)
    {        
        $team->delete();

        return $this->sendResponse($team, 'Team deleted successfully.');
    }
}
