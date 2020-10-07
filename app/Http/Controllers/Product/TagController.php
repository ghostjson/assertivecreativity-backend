<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminAuthMiddleware;
use App\Http\Requests\StoreTagRequest;
use App\Http\Resources\ProductResource;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TagController extends Controller
{

    public function __construct()
    {
        $this->middleware([
            AdminAuthMiddleware::class
        ])->only(['store', 'update']);
    }

    /**
     * Store a new tag
     *
     * @param StoreTagRequest $request
     * @return JsonResponse
     */
    public function store(StoreTagRequest $request) : JsonResponse
    {
        Tag::create($request->validated());

        return respond('Successfully created tag');
    }

    /**
     * Store a new tag
     *
     * @param StoreTagRequest $request
     * @param Tag $tag
     * @return JsonResponse
     */
    public function update(StoreTagRequest $request, Tag $tag) : JsonResponse
    {
        $tag->update($request->validated());

        return respond('Successfully updated tag');
    }

    /**
     * Get all products of a specific category
     *
     * @param Tag $tag
     * @return ResourceCollection
     */
    public function show(Tag $tag) : ResourceCollection
    {
        return ProductResource::collection(
            $tag->products
        );
    }

    /**
     * Get all products of a specific tag name
     *
     * @param string $name
     * @return ResourceCollection
     */
    public function showByName(string $name) : ResourceCollection
    {
        return ProductResource::collection(
            Tag::where('name', $name)->first()->products
        );
    }
}
