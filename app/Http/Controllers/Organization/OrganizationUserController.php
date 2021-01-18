<?php

namespace App\Http\Controllers\Organization;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Models\OrganizationUser;
use App\Models\User;

use App\Http\Requests\Auth\OrganizationUserRegistration;
use App\Http\Requests\Auth\MemberRegistration;

class OrganizationUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('register', 'visibleUsers');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('canControlOrganization');

        $users = OrganizationUser::with(
                        'user', 'user.role', 'user.city', 'user.city.region', 'user.city.region.country'
                    )
                    ->where('organization_id', Auth::user()->organization->id)
                    ->get();

        return response($users, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrganizationUserRegistration $request)
    {
        $this->authorize('canControlOrganization');

        $validated = $request->validated();

        $password = $request->phone_number;

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($password);
        $user->birth_year = $request->birth_year;
        $user->gender = $request->gender;
        $user->phone_number = $request->phone_number;
        $user->language_id = $request->input('language.id');
        $user->city_id = $request->input('city.id');
        $user->organization_id = $request->user()->organization->id;
        $user->save();

        /**
            * Remember to send generated $password to user
        */
        $membership = new OrganizationUser();
        $membership->user_id = $user->id;
        $membership->organization_id = $request->user()->organization->id;
        $membership->verified = 1;
        $membership->expired_at = now();
        $membership->save();

        return response([
            'message' => 'Success'
        ], 200);
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
     * Verify the member for the organization entry.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('canControlOrganization');

        $membership = OrganizationUser::findOrFail($id);
        $membership->verified = 1;
        $membership->expired_at = now();
        $membership->save();

        $member = $membership->user;
        $member->organization_id = $request->user()->organization->id;
        $member->save();

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
        $this->authorize('canControlOrganization');

        $membership = OrganizationUser::findOrFail($id);

        $user = $membership->user;
        $user->organization_id = null;
        $user->role_id = 1;
        $user->save();

        $membership->delete();

        return response([
            'message' => 'Removed'
        ], 200);
    }

    /**
     * Display list of unverified members
    */
    public function unverifiedUsers()
    {
        $this->authorize('canControlOrganization');

        $users = OrganizationUser::with(
                        'user', 'user.city', 'user.city.region', 'user.city.region.country'
                    )
                    ->where('organization_id', Auth::user()->organization->id)
                    ->where('verified', 0)
                    ->get();

        return response($users, 200);
    }

    /**
     * Generate random password
    */
    public function randomPassword()
    {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache

        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }

        return implode($pass); //turn the array into a string
    }

    /*
     * Update member's role
    */
    public function updateRole(Request $request)
    {
        $this->authorize('canControlOrganization');

        $user = User::findOrFail($request->id);
        $user->role_id = $request->role_id;
        $user->save();

        return response([
            'message' => 'success'
        ], 200);
    }

    /*
     * New member registration
    */
    public function register(MemberRegistration $request)
    {
        $validated = $request->validated();

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->organization_id = $request->organization_id;
        $user->subscribed = $request->subscribed;
        $user->save();

        $membership = new OrganizationUser();
        $membership->user_id = $user->id;
        $membership->organization_id = $user->organization_id;
        $membership->verified = 0;
        $membership->expired_at = Carbon::now()->addDays(2);
        $membership->save();

        Auth::login($user);

        return response([
            'message' => 'Success'
        ], 200);
    }

    /*
     * Get languages of all members in the organization
    */
    public function languages()
    {
        $languages = [];

        $members = Auth::user()->organization->members()->where('verified', 1)->get('user_id');

        foreach ($members as $member) {
            $language = User::findOrFail($member->user_id)->language;

            array_push($languages, $language);
        }

        return response($languages, 200);
    }

    /*
     * Get cities of all subscribers in the organization
    */
    public function cities()
    {
        $cities = [];

        $members = Auth::user()->organization->members()->where('verified', 1)->get('user_id');

        foreach ($members as $member) {
            $city = User::findOrFail($member->user_id)->city;

            array_push($cities, $city);
        }

        return response($cities, 200);
    }

    /*
     * Promote user to display on organization's site
    */
    public function promoteMember(Request $request, $id)
    {
        $this->authorize('canControlOrganization');

        $user = OrganizationUser::findOrFail($id);

        // Check if organization has not exceeded their limit for promotion
        if (count($user->organization->members()->where('visible', 1)->get()) > 2) {
            abort(400, 'Limit reached!');
        }

        $user->verified = 1;
        $user->visible = 1;
        $user->save();

        return response($user, 200);
    }

    /*
     * Demote user to not display on organization's site
    */
    public function demoteMember($id)
    {
        $this->authorize('canControlOrganization');

        $user = OrganizationUser::findOrFail($id);
        $user->visible = 0;
        $user->save();

        response($user, 200);
    }

    /*
     * Display listing of visible users
    */
    public function visibleUsers($id)
    {
        $users = OrganizationUser::with('user', 'user.role', 'user.socialProfile')->where('organization_id', $id)->where('visible', 1)->get();

        return response($users, 200);
    }
}
