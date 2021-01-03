<?php

namespace App\Http\Controllers\CustomProduct;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminAuthMiddleware;
use App\Http\Requests\AddTagsToProductRequest;
use App\Http\Requests\StoreTagRequest;
use App\Http\Resources\CustomProductResource;
use App\Http\Resources\TagResource;
use App\Models\CustomProductTag;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Log;

class CustomTagController extends Controller
{

    public function __construct()
    {
        $this->middleware([
            AdminAuthMiddleware::class
        ])->only(['store', 'update', 'destroy', 'addTagsToProduct']);
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
        return CustomProductResource::collection(
            $tag->custom_products
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
            $products = Tag::where('name', $name)->first()->custom_products;
            return CustomProductResource::collection($products);

        }catch (\ErrorException $exception)
        {
            return CustomProductResource::collection([]);
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

    public function addTagsToProduct(AddTagsToProductRequest $request)
    {
        $tag_ids = json_decode($request->input('tag_ids'));

        try{
            foreach ($tag_ids as $tag_id){
                CustomProductTag::create([
                    'custom_product_id' => $request->input('product_id'),
                    'tag_id' => $tag_id
                ]);
            }
            return respond('Tags are successfully added');
        }catch (\Exception $exception){
            dd($exception);
            Log::error($exception);
            return respond('Server Error', 500);
        }
    }


}
