<?php

namespace App\Http\Controllers\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Country;

use App\Http\Requests\StoreCountry;

class CountryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Country::orderBy('name', 'ASC')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCountry $request)
    {
        $this->authorize('canControlEverything');

        $validated = $request->validated();

        $country = new Country();
        $country->name = $request->name;
        $country->phone_index = $request->phone_index;
        $country->save();

        return response($country, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('canControlEverything');

        $country = Country::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|string|unique:countries,name,'.$country->id,
            'phone_index' => 'required|integer'
        ]);

        $country->name = $request->name;
        $country->phone_index = $request->phone_index;
        $country->save();

        return response($country, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('canControlEverything');

        $country = Country::findOrFail($id);
        $country->delete();

        return response([
            'message' => 'success'
        ], 200);
    }
}
