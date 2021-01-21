<?php

namespace App\Http\Controllers\Thread;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminAuthMiddleware;
use App\Http\Requests\CreateFormRequest;
use App\Http\Requests\UpdateFormRequest;
use App\Http\Resources\FormResource;
use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FormController extends Controller
{

    public function __construct()
    {
        $this->middleware(
            AdminAuthMiddleware::class
        );
    }

    public function index()
    {
        return FormResource::collection(Form::all());
    }

    public function show(Form $form)
    {
        return new FormResource($form);
    }

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
}
