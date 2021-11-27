<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Models\Tag;
use App\Resources\TagResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class TagController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Tag::class, 'tag');
    }

    public function index(): JsonResource
    {
        return TagResource::collection(
            QueryBuilder::for(Tag::class)
                ->allowedFilters([
                    AllowedFilter::exact('id'),
                    AllowedFilter::exact('name'),
                ])
                ->get()
        );
    }

    public function store(TagRequest $request): JsonResource
    {
        return new TagResource(Tag::create($request->validated()));
    }

    public function destroy(Tag $tag): JsonResponse
    {
        $tag->deleteOrFail();
        return $this->respondWithSuccess();
    }
}
