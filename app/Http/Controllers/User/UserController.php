<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateProfile;

use App\Models\User;
use App\Models\UserSocial;

class UserController extends Controller
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
        return response(User::with([
            'organization',
            'socialProfile',
            'membership',
            'city',
            'city.country',
            'city.region',
            'language',
            'role'
        ])->find(Auth::id()), 200);
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
    public function update(UpdateProfile $request, $id)
    {
        $validated = $request->validated();

        $user = Auth::user();

        $this->validate($request, [
            'email' => 'required|email|unique:users,email,'.$user->id,
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->birth_year = $request->birth_year;
        $user->gender = $request->gender;
        $user->phone_number = $request->phone_number;
        $user->language_id = $request->input('language.id');
        $user->city_id = $request->input('city.id');

        // Photo Upload
        if ($request->photo && (strlen($request->photo) > 50)) {
            $image = 'images/avatars/'.$user->photo;
            if (file_exists($image)) {
                @unlink($image);
            }

            $file = str_replace(' ', '', str_replace('.', '', microtime())).'.'.explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
            \Image::make($request->photo)->save(public_path('images/avatars/'.$file));
            $user->photo = $file;
        }

        $user->save();

        return response($user, 200);
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
     * Update user social profile
    */
    public function updateSocialProfile(Request $request)
    {
        $user = Auth::user();

        $socialProfile = UserSocial::updateOrCreate(
            ['user_id' => $user->id],
            [
                'skype' => $request->skype,
                'facebook' => $request->facebook,
                'twitter' =>$request->twitter,
                'slack' => $request->slack,
                'discord' => $request->discord,
                'whatsapp' => $request->whatsapp,
                'linkedin' => $request->linkedin
            ]
        );

        return $socialProfile;
    }
}
