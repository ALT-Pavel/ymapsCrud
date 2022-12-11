<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Markers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarkersController extends Controller
{
    public function index()
    {
        $markers = Markers::where('user_id',Auth::user()->id)->get();
        return $markers->toArray();
    }

    public function add(Request $request)
    {
        $marker = new Markers([
            'name' => $request->name,
            'user_id' => Auth::user()->id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude
        ]);
        $marker->save();

        return response()->json('The marker successfully added');
    }

    public function edit($id)
    {
        $marker = Markers::find($id);
        return response()->json($marker);
    }

    public function update($id, Request $request)
    {
        $marker = Markers::find($id);
        $marker->update($request->all());
        $marker->save();

        return response()->json('The marker updated');
    }

    public function delete($id)
    {
        $marker = Markers::find($id);
        $marker->delete();

        return response()->json('The marker successfully deleted');
    }
}
