<?php

namespace App\Http\Controllers\Api\Blog\Admin;

use Illuminate\Http\Request;
use App\Models\BlogCategory;
use App\Models\BlogPost;
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

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 5);
        $search = $request->input('search');

        $paginator = $this->blogCategoryRepository->getAllWithPaginate($perPage, $search);
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
        $childrenCount = BlogCategory::where('parent_id', $id)->count();
        if ($childrenCount > 0) {
            return response()->json([
                'success' => false,
                'message' => "Видалення неможливе: категорія має {$childrenCount} дочірніх підкатегорій."
            ], 400);
        }

        $postsCount = BlogPost::where('category_id', $id)->count();
        if ($postsCount > 0) {
            return response()->json([
                'success' => false,
                'message' => "Видалення неможливе: до категорії прив'язано {$postsCount} статей."
            ], 400);
        }

        $result = BlogCategory::destroy($id);

        if ($result) {
            return response()->json(['success' => true, 'message' => 'Категорію успішно видалено.']);
        }

        return response()->json(['success' => false, 'message' => 'Помилка видалення.'], 500);
    }
}
