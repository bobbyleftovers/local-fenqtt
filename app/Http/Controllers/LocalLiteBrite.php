<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Submissions;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Facades\Log;
use CurlFile;
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
        $submission->filename = ($request['filename']) ? $request['filename'] : '';
        $submission->save();
        // store the image
        // done
        return response()->json($submission);
    }

    public function upload(Request $request)
    {
        $response = Curl::to('http://bobby.af/uploader')
        // ->withFile( 'file', $request->get('path'), 'image/png', 'imageName1.png' )
            ->withData(array('test' => 'Bar'))
            ->post();

        return response()->json([$request->get('path'), $response]);
    }
}
