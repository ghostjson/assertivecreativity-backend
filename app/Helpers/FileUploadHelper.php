<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

if (!function_exists('fileUploader')) {

    /**
     * Store a base64 file to storage
     *
     * @param
     * @return
     */
    function fileUploader(string $base64_file)
    {
        $data = substr($base64_file, strpos($base64_file, ',') + 1);

        $file_name = uniqid(time() . '_', true) .  '.png';

        $image = base64_decode($data);
        Storage::disk('local')->put('public/' . $file_name, $image);

        return $file_name;
    }
}
