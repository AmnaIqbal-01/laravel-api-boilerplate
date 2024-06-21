<?php

use App\Mail\SendMail;
use App\Models\InvitedUser;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Carbon\Carbon;
use App\Http\Requests\Api\v1_0\DealStoreRequest;



function sendEmailWithTryCatch($email, $msg, $subject, $view, $name)
{
    try {
        \Illuminate\Support\Facades\Mail::to($email)->send(new SendMail($name, $msg, $subject, $view));

        // \Illuminate\Support\Facades\Mail::to($email)->queue(new SendMail($name, $msg, $subject, $view));
        return true;
        // You can add any additional success handling here if needed
    } catch (\Exception $e) {
        Log::error('email err ' . $e->getMessage());
        return false;
    }
}
function parseToArray($arrayString)
{
    $array = json_decode($arrayString, true);
    return is_array($array) ? $array : [];
}
function saveFile($file, $folderName, $fileName)
{
    try {
        // Create the directory if it doesn't exist
        $directory = dirname(storage_path('app/public' . $folderName));
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        // Store the file
        $stored = $file->storeAs('public/' . $folderName, $fileName);

        if ($stored) {
            return true; // File saved successfully
        } else {
            return false; // Failed to save file
        }
    } catch (\Exception $e) {
        // Handle any exceptions
        \Log::error('Error saving file: ' . $e->getMessage());
        return false; // Failed to save file due to exception
    }
}

function removeExistingImage($link)
{
    $storagePath = 'public/' . $link;

    // Delete the file if it exists
    if (Storage::disk('local')->exists($storagePath)) {
        Storage::disk('local')->delete($storagePath);
    }
}
function convertToUTC($date)
{
    if (!empty($date)) {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date, config('app.timezone'))
            ->setTimezone('UTC')
            ->toDateString(); // Converts to Y-m-d format
    }
    return null;
}
function getDistanceFromLocation($location, $userLongitude, $userLatitude)
{

    try {
        if (empty($location)) {
            throw new \Exception('Location data is empty');
        }

        // Assuming $location is an object with latitude and longitude properties. Adjust if necessary.
        $latitudeRad = deg2rad($location->latitude);
        $longitudeRad = deg2rad($location->longitude);
        $userLatitudeRad = deg2rad($userLatitude);
        $userLongitudeRad = deg2rad($userLongitude);

        // Calculate differences in latitude and longitude
        $latDiff = $latitudeRad - $userLatitudeRad;
        $lonDiff = $longitudeRad - $userLongitudeRad;

        // Haversine formula calculation
        $angle = 2 * asin(sqrt(pow(sin($latDiff / 2), 2) + cos($userLatitudeRad) * cos($latitudeRad) * pow(sin($lonDiff / 2), 2)));
        $distance = $angle * 6371000; // Earth's radius in meters

    } catch (\Exception $e) {
        \Log::error('Error calculating distance: ' . $e->getMessage());
        return null; // Or handle the exception as needed
    }

    // Return the distance for a single location
    return $distance;
}
