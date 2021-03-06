<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

if (!function_exists('fileUploader')) {

    /**
     * Store a base64 file to storage
     *
     * @param string $base64_file
     * @return string
     */
    function fileUploader(string $base64_file): string
    {
        $data = substr($base64_file, strpos($base64_file, ',') + 1);

        $type = explode('/', substr($base64_file, 0, strpos($base64_file, ';')))[1];
        $file_name = uniqid(time() . '_', true) .  '.' . $type;

        $image = base64_decode($data);
        Storage::disk('s3')
            ->put('files/'. $file_name, $image);
        return $file_name;
    }
}
