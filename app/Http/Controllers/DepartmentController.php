<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiOperationFailedException;
use App\Http\Controllers\BaseController;
use App\Http\Requests\CreateDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;
use App\Repositories\Contracts\DepartmentRepositoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class DepartmentController
 */
class DepartmentController extends BaseController
{
    /** @var  DepartmentRepositoryInterface */
    private $departmentRepository;

    public function __construct(DepartmentRepositoryInterface $departmentRepo)
    {
        $this->departmentRepository = $departmentRepo;
    }

    /**
     * Display a listing of the Department.
     * GET|HEAD /departments
     *
     * @param  Request  $request
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $input = $request->except(['skip', 'limit']);
        $departments = $this->departmentRepository->all(
            $input,
            $request->get('skip'),
            $request->get('limit')
        );

        $input['withCount'] = 1;

        return $this->sendResponse(
            $departments->toArray(),
            'Departments retrieved successfully.',
            ['totalRecords' => $this->departmentRepository->all($input)]
        );
    }

    /**
     * Store a newly created Department in storage.
     * POST /departments
     *
     * @param  CreateDepartmentRequest  $request
     *
     * @throws ApiOperationFailedException
     *
     * @return JsonResponse
     */
    public function store(CreateDepartmentRequest $request)
    {
        $input = $request->all();

        $department = $this->departmentRepository->create($input);

        return $this->sendResponse($department->toArray(), 'Department saved successfully.');
    }

    /**
     * Display the specified Department.
     * GET|HEAD /departments/{id}
     *
     * @param  Department  $department
     *
     * @return JsonResponse
     */
    public function show(Department $department)
    {
        $department = Department::with(['teams'])->findOrFail($department->id);

        return $this->sendResponse($department->toArray(), 'Department retrieved successfully.');
    }

    /**
     * Update the specified Department in storage.
     * PUT/PATCH /departments/{id}
     *
     * @param  Department  $department
     * @param  UpdateDepartmentRequest  $request
     *
     * @throws ApiOperationFailedException
     * @return JsonResponse
     */
    public function update(Department $department, UpdateDepartmentRequest $request)
    {
        $input = $request->all();
        $department = Department::findOrFail($department->id);
        echo json_encode($department);
        die;

        $updatedDepartment = $this->departmentRepository->update($input, $department->id);

        return $this->sendResponse($updatedDepartment->toArray(), 'Department updated successfully.');
    }

    /**
     * Remove the specified Department from storage.
     * DELETE /departments/{id}
     *
     * @param  Department  $department
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function destroy(Department $department)
    {
        if (! empty($department->teams->toArray())) {
            throw new BadRequestHttpException('Department can not be delete, it is has one or more team items.');
        }
        $department->delete();

        return $this->sendResponse($department, 'Department deleted successfully.');
    }
}
