<?php

namespace App\Http\Controllers\Organization;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Http\Requests\UpdateOrganization;

use App\Models\Organization;
use App\Models\OrganizationUser;

class OrganizationController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $organization = Organization::with('city', 'city.region', 'city.region.country')->where('id', Auth::user()->organization->id)->first();

        return response($organization, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $organization = new Organization();
        $organization->name = $request->name;
        $organization->slogan = $request->slogan;
        $organization->description = $request->description;
        $organization->address = $request->address;
        $organization->affiliate = $request->affiliate;
        $organization->city_id = $request->input('city.id');

        // Photo Upload
        $file = str_replace(' ', '', str_replace('.', '', microtime())).'.'.explode('/', explode(':', substr($request->logo, 0, strpos($request->logo, ';')))[1])[1];
        \Image::make($request->logo)->save(public_path('images/logos/'.$file));
        $organization->logo = $file;

        $organization->save();

        $member = new OrganizationUser();
        $member->organization_id = $organization->id;
        $member->user_id = $request->user()->id;
        $member->verified = 1;
        $member->expired_at = Carbon::now();
        $member->save();

        $user = Auth::user();
        $user->organization_id = $organization->id;
        $user->role_id = \App\Models\Role::where('name', 'admin')->first()->id;
        $user->save();
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
    public function update(UpdateOrganization $request, $id)
    {
        $this->authorize('canControlOrganization');

        $validated = $request->validated();

        $organization = Organization::findOrFail($id);
        $organization->name = $request->name;
        $organization->slogan = $request->slogan;
        $organization->description = $request->description;
        $organization->address = $request->address;
        $organization->affiliate = $request->affiliate;
        $organization->city_id = $request->input('city.id');

        // Photo Upload
        if ($request->logo && (strlen($request->logo) > 50)) {
            $image = 'images/logos/'.$organization->logo;
            if (file_exists($image)) {
                @unlink($image);
            }

            $file = str_replace(' ', '', str_replace('.', '', microtime())).'.'.explode('/', explode(':', substr($request->logo, 0, strpos($request->logo, ';')))[1])[1];
            \Image::make($request->logo)->save(public_path('images/logos/'.$file));
            $organization->logo = $file;
        }

        $organization->save();

        return response($organization, 200);
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

    /**
     * Update organization's affiliate settings
    */
    public function updateAffiliate(Request $request)
    {
        $this->authorize('canControlOrganization');

        $organization = Auth::user()->organization;
        if ($organization->affiliate == 1)
            $organization->affiliate = 0;
        else
            $organization->affiliate = 1;

        $organization->save();

        return response([
            'message' => 'Success'
        ], 200);
    }
}
