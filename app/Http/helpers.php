<?php

if (!function_exists('move_file')) {
    function move_file($file, $type = 'avatar', $withWatermark = false)
    {
        // Grab all variables
        $destinationPath = config('variables.' . $type . '.folder');
        $width = config('variables.' . $type . '.width');
        $height = config('variables.' . $type . '.height');
        $full_name = str_random(16) . '.' . $file->getClientOriginalExtension();

        if ($width == null && $height == null) { // Just move the file
            $file->storeAs($destinationPath, $full_name);
            return $full_name;
        }


        // Create the Image
        $image = Image::make($file->getRealPath());

        if ($width == null || $height == null) {
            $image->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
        } else {
            $image->fit($width, $height);
        }

        if ($withWatermark) {
            $watermark = Image::make(public_path() . '/img/watermark.png')->resize($width * 0.5, null);

            $image->insert($watermark, 'center');
        }

        Storage::put($destinationPath . '/' . $full_name, (string)$image->encode());

        return $full_name;
    }
}

function compute_month_diff($date1, $date2)
{
    $month = 0;
    $year = 0;
    $duration = '';

    $d1 = new DateTime($date1);
    $d2 = new DateTime($date2);

    $interval = $d2->diff($d1);
    $total = $interval->m + ($interval->y * 12);

    $result = $total == 0 ? $interval->d . ' days' : $total . ' months';
    return $result;
}

function getAmountAttribute($value)
{
    return number_format($value,2);
}