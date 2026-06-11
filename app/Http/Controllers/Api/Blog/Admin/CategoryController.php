<?php

namespace App\Http\Controllers\Api\Blog\Admin;

use Illuminate\Http\Request;
use App\Models\BlogCategory;
use App\Repositories\BlogCategoryRepository;
use App\Http\Requests\BlogCategoryCreateRequest;
use App\Http\Requests\BlogCategoryUpdateRequest;
use Illuminate\Support\Str;
use App\Http\Resources\Api\Blog\Admin\CategoryResource;

class CategoryController extends BaseController
{
    private $blogCategoryRepository;

    public function __construct(BlogCategoryRepository $blogCategoryRepository)
    {
        parent::__construct();
        $this->blogCategoryRepository = $blogCategoryRepository;
    }

    public function index()
    {
        $paginator = $this->blogCategoryRepository->getAllWithPaginate(5);
        return CategoryResource::collection($paginator);
    }

    public function store(BlogCategoryCreateRequest $request)
    {
        $data = $request->input();
        $item = (new BlogCategory())->create($data);

        if ($item) {
            return response()->json([
                'success' => true,
                'message' => 'Успішно збережено',
                'id' => $item->id
            ], 201);
        }

        return response()->json(['success' => false, 'message' => 'Помилка збереження'], 500);
    }

    public function update(BlogCategoryUpdateRequest $request, string $id)
    {
        $item = $this->blogCategoryRepository->getEdit($id);

        if (empty($item)) {
            return response()->json(['success' => false, 'message' => "Запис id=[{$id}] не знайдено"], 404);
        }

        $data = $request->all();
        $result = $item->update($data);

        if ($result) {
            return response()->json(['success' => true, 'message' => 'Успішно збережено']);
        }

        return response()->json(['success' => false, 'message' => 'Помилка збереження'], 500);
    }

    public function show(string $id)
    {
        $item = BlogCategory::find($id);

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Запис не знайдено'], 404);
        }

        return new CategoryResource($item);
    }

    public function destroy(string $id)
    {
        $result = BlogCategory::destroy($id);

        if ($result) {
            return response()->json(['success' => true, 'message' => 'Категорію видалено']);
        }

        return response()->json(['success' => false, 'message' => 'Помилка видалення'], 500);
    }
}
