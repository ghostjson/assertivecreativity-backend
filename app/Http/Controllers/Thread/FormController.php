<?php

namespace App\Http\Controllers\Thread;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminAuthMiddleware;
use App\Http\Requests\CreateFormRequest;
use App\Http\Requests\SaveFormResponse;
use App\Http\Requests\UpdateFormRequest;
use App\Http\Resources\FormResource;
use App\Http\Resources\FormResponseResource;
use App\Models\Form;
use App\Models\FormResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;

class FormController extends Controller
{

    public function __construct()
    {
        $this->middleware(
            AdminAuthMiddleware::class
        )->except(['saveFormResponse']);
    }

    /**
     * List all forms
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return FormResource::collection(Form::all());
    }

    /**
     * Show a particular form
     * @param Form $form
     * @return FormResource
     */
    public function show(Form $form)
    {
        return new FormResource($form);
    }

    /**
     * Save a form
     * @param CreateFormRequest $request
     * @return JsonResponse
     */
    public function store(CreateFormRequest $request)
    {
        try {
            $form = Form::create($request->validated());
            return respondWithObject('Successfully created form', new FormResource($form));
        }catch (\Exception $exception){
            Log::error($exception);
            return respond('Error creating form', 500);
        }
    }

    /**
     * Update a form
     * @param UpdateFormRequest $request
     * @param Form $form
     * @return JsonResponse
     */
    public function update(UpdateFormRequest $request, Form $form)
    {
        try {
            $form->update($request->validated());
            return respondWithObject('Successfully update form', new FormResource($form));
        }catch (\Exception $exception){
            Log::error($exception);
            return respond('Error update form', 500);
        }
    }

    /**
     * Delete a form
     * @param Form $form
     * @return JsonResponse
     */
    public function delete(Form $form)
    {
        try {
            $form->delete();
            return respondWithObject('Successfully deleted form', $form);
        }catch (\Exception $exception){
            Log::error($exception);
            return respond('Error delete form', 500);
        }
    }

//    RESPONSE

    /**
     * Get a form response
     * @param FormResponse $formResponse
     * @return FormResponseResource
     */
    public function getFormResponse(FormResponse $formResponse)
    {
        return new FormResponseResource($formResponse);
    }

    /**
     * Save a form response
     * @param SaveFormResponse $response
     * @return JsonResponse
     */
    public function saveFormResponse(SaveFormResponse $response)
    {
        try {
            FormResponse::create($response->validated());
            return respond("Successfully saved form response");
        }catch (\Exception $exception){
            Log::error($exception);
            return respond("Error saving form", 500);
        }
    }

    /**
     * Get all responses of a particular form
     * @param Form $form
     * @return AnonymousResourceCollection
     */
    public function getAllResponses(Form $form)
    {
        return FormResponseResource::collection($form->responses);
    }
}
