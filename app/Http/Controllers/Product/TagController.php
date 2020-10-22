<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminAuthMiddleware;
use App\Http\Requests\StoreTagRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use function PHPUnit\Framework\isNull;

class TagController extends Controller
{

    public function __construct()
    {
        $this->middleware([
            AdminAuthMiddleware::class
        ])->only(['store', 'update', 'destroy']);
    }


    /**
     * Return all tags
     * @return ResourceCollection
     */
    public function index() : ResourceCollection
    {
        return TagResource::collection(Tag::all());
    }

    /**
     * Store a new tag
     *
     * @param StoreTagRequest $request
     * @return JsonResponse
     */
    public function store(StoreTagRequest $request) : JsonResponse
    {
        $tag = Tag::create($request->validated());

        return respondWithObject('Successfully created tag', $tag);
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

        return respondWithObject('Successfully updated tag', $tag);
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
        try {
            $products = Tag::where('name', $name)->first()->products;
            return ProductResource::collection($products);

        }catch (\ErrorException $exception)
        {
            return ProductResource::collection([]);
        }


    }

    /**
     * Delete a tag
     * @param Tag $tag
     * @return JsonResponse
     */
    public function destroy(Tag $tag)
    {
        try {
            $tag->delete();
            return respond('Tag is successfully deleted');
        }
        catch (\Exception $exception)
        {
            return respond('Tag cannot delete', 500);
        }
    }


}
