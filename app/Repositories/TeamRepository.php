<?php

namespace App\Repositories;

use App\Models\Team;
use App\Repositories\Contracts\TeamRepositoryInterface;

/**
 * Class TeamRepository
 */
class TeamRepository extends BaseRepository implements TeamRepositoryInterface
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
        return Team::class;
    }

    /**
     * @param  array  $search
     * @param  int|null  $skip
     * @param  int|null  $limit
     * @param  array  $columns
     *
     * @return Team[]|Collection|int
     */
    public function all($search = [], $skip = null, $limit = null, $columns = ['*'])
    {
        $orderBy = null;
        if (! empty($search['order_by']) && ($search['order_by'] == 'department_name')) {
            $orderBy = $search['order_by'];
            unset($search['order_by']);
        }
        $query = $this->allQuery($search, $skip, $limit)->with('department');

        if (! empty($search['withCount'])) {
            return $query->count();
        }

        $teams = $query->orderByDesc('id')->get();

        if (! empty($orderBy)) {
            $sortDescending = ($search['direction'] == 'asc') ? false : true;
            $orderString = '';

            if ($orderBy == 'department_name') {
                $orderString = 'department';
            }

            $teams = $teams->sortBy($orderString, SORT_REGULAR, $sortDescending);
        }

        return $teams->values();
    }
}
