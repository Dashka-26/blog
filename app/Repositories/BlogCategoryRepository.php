<?php

namespace App\Repositories;

use App\Models\BlogCategory as Model;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class BlogCategoryRepository.
 */
class BlogCategoryRepository extends CoreRepository
{
    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     * Отримати модель для редагування в адмінці
     * @param int $id
     * @return Model
     */
    public function getEdit($id)
    {
        return $this->startConditions()->find($id);
    }

    /**
     * Отримати список категорій для виводу в випадаючий список
     */
    public function getForComboBox()
    {
        $columns = implode(', ', [
            'id',
            'CONCAT (id, ". ", title) AS id_title',  //додаємо поле id_title
        ]);

        $result = $this                           //2 варіант
        ->startConditions()
            ->selectRaw($columns)
            ->toBase()
            ->get();

        return $result;
    }

    /**
     * Отримати категорію для виводу пагінатором
     * * @param int|null $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllWithPaginate($perPage = null, $search = null)
    {
        $columns = ['id', 'title', 'slug', 'parent_id'];

        $query = $this
            ->startConditions()
            ->select($columns)
            ->with(['parentCategory:id,title']);

        if (!empty($search)) {
            $query->where('title', 'LIKE', "%{$search}%");
        }

        return $query->paginate($perPage);
    }
}
