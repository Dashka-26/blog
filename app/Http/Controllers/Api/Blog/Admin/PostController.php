<?php

namespace App\Http\Controllers\Api\Blog\Admin;

use Illuminate\Http\Request;
use App\Models\BlogPost;
use App\Http\Requests\BlogPostCreateRequest;
use App\Http\Requests\BlogPostUpdateRequest;
use App\Repositories\BlogPostRepository;
use App\Repositories\BlogCategoryRepository;
use App\Jobs\BlogPostAfterCreateJob;
use App\Jobs\BlogPostAfterDeleteJob;
use App\Http\Resources\Api\Blog\Admin\PostResource;

class PostController extends BaseController
{
    public function __construct(
        private BlogPostRepository $blogPostRepository,
        private BlogCategoryRepository $blogCategoryRepository
    ) {
        parent::__construct();
    }

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 5);
        $search = $request->input('search');

        $paginator = $this->blogPostRepository->getAllWithPaginate($perPage, $search);
        return PostResource::collection($paginator);
    }

    public function show(string $id)
    {
        $item = BlogPost::find($id);

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Запис не знайдено'], 404);
        }

        return new PostResource($item);
    }

    public function update(BlogPostUpdateRequest $request, string $id)
    {
        $item = $this->blogPostRepository->getEdit($id);

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

    public function store(BlogPostCreateRequest $request)
    {
        $data = $request->input();
        $item = (new BlogPost())->create($data);

        if ($item) {
            $job = new BlogPostAfterCreateJob($item);
            dispatch($job);

            return response()->json([
                'success' => true,
                'message' => 'Успішно збережено',
                'id' => $item->id
            ], 201);
        }

        return response()->json(['success' => false, 'message' => 'Помилка збереження'], 500);
    }

    public function destroy(string $id)
    {
        $result = BlogPost::destroy($id);

        if ($result) {
            BlogPostAfterDeleteJob::dispatch($id)->delay(20);

            return response()->json(['success' => true, 'message' => 'Статтю видалено']);
        }

        return response()->json(['success' => false, 'message' => 'Помилка видалення'], 500);
    }
}
