<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\City;
use App\Models\Region;
use App\Models\UserLocation;
use App\Http\Requests\Auth\UserRegistration;

use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(Auth::user(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function update(UserRegistration $request, $id)
    {
        $validated = $request->validated();

        $user = User::findOrFail($id);
        $user->birth_year = $request->birth_year;
        $user->gender = $request->gender;
        $user->phone_number = $request->phone_number;
        $user->language_id = $request->input('language.id');
        $user->projects = $request->project;


        $region = Region::firstOrCreate(['name' => $request->region], ['country_id' => $request->input('country.id')]);
        
        $city = City::firstOrCreate(['name' => $request->city], ['country_id' => $request->input('country.id'), 'latitude' => 0, 'longitude' => 0, 'region_id' => $region->id]);

        $user->city_id = $city->id;

        // Photo Upload
        if ($request->photo) {
            
            $file = str_replace(' ', '', str_replace('.', '', microtime())).'.'.explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
            \Image::make($request->photo)->save(public_path('images/avatars/'.$file));
            $user->photo = $file;
        }

        $user->save();

        return response([
            'message' => 'Success'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
