<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;

class ajaxDataController extends Controller
{


    public function allData()
    {
        $data = Teacher::orderBy('id','DESC')->get();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'desi' => 'required',
            'inst' => 'required',
        ]);
        $data = Teacher::insert([
            'name' => $request->name,
            'desi' => $request->desi,
            'inst' => $request->inst,
        ]);
        return response()->json($data);
    }

    public function edit(Teacher $id)
    {
        // $data = $id;
        return response()->json($id);

    }

    public function update(Teacher $id,Request $request)
    {
        $request->validate([
            'name' => 'required',
            'desi' => 'required',
            'inst' => 'required',
        ]);
        $data = $id->update([
            'name' => $request->name,
            'desi' => $request->desi,
            'inst' => $request->inst,
        ]);
        return response()->json($data);
    }

    public function destroy(Teacher $id)
    {
        return response()->json($id->delete());
    }
}
