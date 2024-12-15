<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Storage;

class Helpers
{

    public static function user_formatted_date($value = null) {

        $date = date('d M, Y', strtotime($value));

        return $date;
    }

    public static function update(string $dir, $old_image, string $format, $image = null)
    {
        if ($image == null) {
            return $old_image;
        }
        if (Storage::disk('public')->exists($dir . $old_image)) {
            Storage::disk('public')->delete($dir . $old_image);
        }
        $imageName = Helpers::upload($dir, $format, $image);
        return $imageName;
    }

    public static function upload(string $dir, string $format, $image = null)
    {
        if ($image != null) {
            $imageName = \Carbon\Carbon::now()->toDateString() . "-" . uniqid() . "." . $format;
            if (!Storage::disk('public')->exists($dir)) {
                Storage::disk('public')->makeDirectory($dir);
            }
            Storage::disk('public')->put($dir . $imageName, file_get_contents($image));
            return $imageName;
        }
    }

    public static function file_upload($request, $file_name, $upload_dir)
    {
        if ($request->hasFile($file_name)) {
            $file = $request->$file_name;
            $filename = time() . '_' . $file->getClientOriginalName();
            $up_path = "uploads/".date('Y-m')."/$upload_dir/";
            $path = $file->move($up_path, $filename);
            if ($file->getError()) {
                $request->session()->flash('warning', $file->getErrorMessage());

                return false;
            }

            return $path;
        }
    }
}

