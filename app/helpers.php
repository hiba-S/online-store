<?php
use Illuminate\Support\Facades\Storage;

if(!function_exists('upload_file'))
{
    function upload_file($request_file, $prefix, $folder_name, $disk='public')
    {
        $extension = $request_file->getClientOriginalExtension();
        $file_name = $prefix . '_' . time() . '.' . $extension;
        $stored_path = $request_file->storeAs($folder_name, $file_name, $disk);
        return $stored_path;
    }
}

if(!function_exists('delete_file_if_exist'))
{
    function delete_file_if_exist($file, $disk='public')
    {
        $path = $disk.$file;
        if(Storage::exists($path))
            Storage::delete($path);
    }
}
