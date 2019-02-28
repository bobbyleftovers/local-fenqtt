<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Submissions;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Image;

class LocalLiteBrite extends Controller
{
    public function index()
    {
        return view('main');
    }

    public function store(Request $request)
    {
        // create a new db record
        $submission = new Submissions;
        $submission->base64 = $request['screenshot'];
        $submission->f_name = ($request['f_name']) ? $request['f_name'] : '';
        $submission->l_name = ($request['l_name']) ? $request['l_name'] : '';
        $submission->email = ($request['email']) ? $request['email'] : '';
        $submission->filename = ($request['filename']) ? $request['filename'] : 'liteBrite-' . Carbon::now()->timestamp . '.jpg';
        $submission->save();
        
        // done
        return response()->json($submission);
    }

    public function upload(Request $request)
    {
        Log::info('Uploader start');
        // pick up the submission we're sending out
        $submission = Submissions::where('id', $request['id'])->first();

        // use curl to send it
        $response = Curl::to('http://bobby.af/uploader')
            ->withData(array(
                'base64' => $submission->base64,
                'filename' => $submission->filename,
                'f_name' => $submission->f_name,
                'l_name' => $submission->l_name,
                'email' => $submission->email
            ))
            ->post();

        $decoded = json_decode($response);
        $submission->foreign_id = $decoded->id;
        $submission->config_id = $decoded->config_id;
        $submission->save();

        // done
        return response()->json($decoded);
    }
}
