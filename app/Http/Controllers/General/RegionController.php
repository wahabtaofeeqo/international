<?php

namespace App\Http\Controllers\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Region;

use App\Http\Requests\StoreRegion;

class RegionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('index', 'showCountryRegions');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Region::with('country')->orderBy('name', 'ASC')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRegion $request)
    {
        $this->authorize('canControlEverything');

        $validated = $request->validated();

        $region = new Region();
        $region->name = $request->name;
        $region->country_id = $request->input('country.id');
        $region->save();

        return response($region, 200);
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

        $region = Region::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|string|unique:regions,name,'.$region->country_id,
            'country.id' => 'required'
        ]);

        $region->name = $request->name;
        $region->country_id = $request->input('country.id');
        $region->save();

        return response($region, 200);
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

        $region = Region::findOrFail($id);
        $region->delete();

        return response([
            'message' => 'success'
        ], 200);
    }

    /**
     * List the regions in a selected country
    */
    public function showCountryRegions($id)
    {
        return Region::with('country')->where('country_id', $id)->get();
    }
}
