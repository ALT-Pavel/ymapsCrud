<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Markers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

    /**
     * Get a validator for an incoming markers request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:100'],
            'latitude' => ['required', 'string', 'max:15',],
            'longitude' => ['required', 'string', 'max:15',],
        ]);
    }
}
