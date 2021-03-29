<?php

namespace App\Repositories;

use App\Models\Department;
use App\Repositories\Contracts\DepartmentRepositoryInterface;

/**
 * Class DepartmentRepository
 */
class DepartmentRepository extends BaseRepository implements DepartmentRepositoryInterface
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Department::class;
    }

    /**
     * @param  array  $search
     * @param  int|null  $skip
     * @param  int|null  $limit
     * @param  array  $columns
     *
     * @return Department[]|Collection|int
     */
    public function all($search = [], $skip = null, $limit = null, $columns = ['*'])
    {
        $orderBy = null;
        if (! empty($search['order_by']) && ($search['order_by'] == 'team_name')) {
            $orderBy = $search['order_by'];
            unset($search['order_by']);
        }

        $query = $this->allQuery($search, $skip, $limit)->with('teams');

        if (! empty($search['withCount'])) {
            return $query->count();
        }

        $departments = $query->orderByDesc('id')->get();

        if (! empty($orderBy)) {
            $sortDescending = ($search['direction'] == 'asc') ? false : true;
            $orderString = '';

            if ($orderBy == 'team_name') {
                $orderString = 'teams';
            }

            $departments = $departments->sortBy($orderString, SORT_REGULAR, $sortDescending);
        }

        return $departments->values();
    }
}
