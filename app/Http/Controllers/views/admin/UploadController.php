<?php

namespace App\Http\Controllers\views\admin;

use Auth;
use App\Utilities\Uploads;
use Illuminate\Http\Request;
use App\Models\File as IzyFile;
use App\Models\Modele;
use App\Models\Booking;
use App\Models\Settings;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
    use Uploads;


    /**
     * Upload file to model
     * @param  Request           $request     [description]
     * @param  [type]            $id          [description]
     * @return [type]                         [description]
     */
    public function modelUpload (Request $request, $id)
    {
        try
        {
            $model = Modele::where('id', $id)->firstOrFail();

            $file = $request->file;
            $directory = self::MODEL_UPLOADS_DIRECTORY;
            $file = $this->upload($file, $directory);

            $model->files()->create([
                'link' => $file->link,
                'name' => $file->name
            ]);

        }
        catch (Exception $e) {
            return response()->json(['message'=>'internal server error'], self::HTTP_ERROR);
        }
    }

    /**
     * Upload file to booking
     * @param  Request           $request     [description]
     * @param  [type]            $id          [description]
     * @return [type]                         [description]
     */
    public function bookingUpload (Request $request, $id)
    {
        try
        {
            $booking = Booking::where('id', $id)->firstOrFail();

            $file = $request->file;
            $directory = self::BOOKING_UPLOADS_DIRECTORY;
            $file = $this->upload($file, $directory);

            $booking->files()->create([
                'link' => $file->link,
                'name' => $file->name
            ]);

        }
        catch (Exception $e) {
            return response()->json(['message'=>'internal server error'], self::HTTP_ERROR);
        }
    }

    /**
     * Upload file to Home Slider
     * @param  Request           $request     [description]
     * @param  [type]            $id          [description]
     * @return [type]                         [description]
     */
    public function sliderUpload (Request $request, $id)
    {
        try
        {
            $setting = Settings::where('id', $id)->firstOrFail();

            $file = $request->file;
            $directory = self::SLIDER_UPLOADS_DIRECTORY;
            $file = $this->upload($file, $directory);

            $setting->files()->create([
                'link' => $file->link,
                'name' => $file->name
            ]);

        }
        catch (Exception $e) {
            return response()->json(['message'=>'internal server error'], self::HTTP_ERROR);
        }
    }

}
