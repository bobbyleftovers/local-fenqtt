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
        // store the image
        // done
        return response()->json($request['screenshot']);
    }

    public function upload()
    {
        // run the upload
    }
}
