<?php

namespace Tests\Unit\Http\Controller;

use Mockery as m;
use Tests\TestCase;
use Illuminate\Http\Request;
use App\Repositories\Contracts\DepartmentRepositoryInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use App\Http\Controllers\DepartmentController;
use App\Models\Department;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DepartmentControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $departmentRepositoryMock;
    
    public function setUp() : void
    {
        $this->afterApplicationCreated(function () {
            $this->departmentRepositoryMock = m::mock(DepartmentRepositoryInterface::class);
            
            $this->departmentController = new DepartmentController(
                $this->app->instance(DepartmentRepositoryInterface::class, $this->departmentRepositoryMock)
            );
        });
        parent::setUp();
    }

    public function mock($class)
    {
        $this->mock = Mockery::mock($class);

        $this->app->instance($class, $this->mock);

        return $this->mock;
    }

    public function test_index()
    {
        $this->actingAs($this->getAdminUser(), 'api');
        
        $departmentMock = m::mock(Department::class)->makePartial();
        $departmentMock->shouldReceive('all')->with()->andReturn(1);
        $this->shouldReceive('departmentRepository')->once()->andReturn($departmentMock);
        $res = $this->departmentController->show($departmentMock);
        $this->assertInstanceOf(JsonResponse::class, $res);
    }

}
