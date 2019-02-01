<?php

namespace App\Http\Controllers;

use App\File;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FileController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload()
    {
        //
        return view('upload');
    }

/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $success = false;
        $path = "";
        $file_name = "";

        $this->validate($request, [

                'file' => 'required',
                'file.*' => 'mimes:xlsx,xls,csv'

        ]);        
        
        if($request->hasfile('file'))
        {
            $file_name=strtolower(str_replace(" ", "_", $request->file('file')->getClientOriginalName()));
            $path = "uploads" . "\\" . strtolower($user->username);
            $success = $request->file('file')->storeAs($path, $file_name);
        }

        if (!empty($success)){
            $file = new File;
            $file->user_id = $user->id;
            $file->file_name = $file_name;
            $file->folder_name = strtolower($user->username);
            $file->folder_path = $path;
            $file->file_used = $file_name;
            $file->status = User::ACTIVE;
            $file->save();

            $user->has_file = true;
            $user->save();

            return redirect()->route('home')->with('success', 'Your DIYTrafficGuy Spreadsheet file has been successfully uploaded!');
        }
        else {
            return back()->with('error', 'Uploading was not successfully! Please try again!');
        }
    }
}
