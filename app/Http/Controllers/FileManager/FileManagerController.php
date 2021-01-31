<?php

namespace App\Http\Controllers\FileManager;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminAuthMiddleware;
use App\Http\Requests\UploadFileRequest;
use Illuminate\Http\Request;

class FileManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware([
            AdminAuthMiddleware::class
        ]);
    }

    public function upload(UploadFileRequest $request)
    {
        return [
            'url' => 'https://ac-files.s3.us-east-2.amazonaws.com/files/' . fileUploader($request->input('file'))
        ];
    }
}
