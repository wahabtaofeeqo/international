<?php

namespace App\Http\Controllers\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\City;
use App\Models\Region;
use App\Http\Requests\StoreCity;

class CityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('index', 'showRegionCities', 'cities', 'showCountryCities');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return City::with('country')->orderBy('name', 'ASC')->paginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCity $request)
    {
        $this->authorize('canControlEverything');

        $validated = $request->validated();

        $city = new City();
        $city->name = $request->name;
        $city->latitude = $request->latitude;
        $city->longitude = $request->longitude;

        $region = Region::firstOrCreate(['name' => $request->region], ['country_id' => $request->input('country.id')]);
        $city->region_id = $region->id;
        $city->save();

        return response($city, 200);
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
    public function update(StoreCity $request, $id)
    {
        $this->authorize('canControlEverything');

        $validated = $request->validated();

        $city = City::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|string|unique:cities,name,'.$city->region_id,
            'region' => 'required'
        ]);

        $city->name = $request->name;
        $city->latitude = $request->latitude;
        $city->longitude = $request->longitude;

        $region = Region::firstOrCreate(['name' => $request->region], ['country_id' => $request->input('country.id')]);
        $city->region_id = $region->id;

        $city->save();

        return response($city, 200);
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

        $city = City::findOrFail($id);
        $city->delete();

        return response([
            'message' => 'success'
        ], 200);
    }

    /**
     * List the cities in a selected region
    */
    public function showRegionCities($id)
    {
        return City::with([
            'region',
            'region.country'
        ])->where('region_id', $id)->get();
    }

    public function showCountryCities($id) {
        return City::with([
            'region',
            'region.country'
        ])->where('country_id', $id)->get();
    }

    public function cities($name, $countryID = null) {

        return City::with([
            'region'
        ])->whereLike('name', $name, 'country_id', $countryID)->limit(10)->get();
    }
}