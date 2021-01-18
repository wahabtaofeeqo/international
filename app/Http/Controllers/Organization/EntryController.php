<?php

namespace App\Http\Controllers\Organization;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Organization;
use App\Models\OrganizationUser;

use App\Http\Requests\RegisterOrganization;

class EntryController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth');
    }

    public function register(RegisterOrganization $request)
    {
    	$validated = $request->validated();

        // Check if organization already exists
        $existence = Organization::where('name', $request->name)
                                ->where('slogan', 'LIKE', '%'.$request->slogan.'%')
                                ->first();
        if (!is_null($existence)) {
            return abort(409, $existence);
        }

    	app(OrganizationController::class)->store($request);

        return response([
        	'message' => 'success'
        ], 200);
    }

    public function join(Request $request)
    {
        $organization = Organization::where('name', $request->name)
                                ->where('slogan', 'LIKE', '%'.$request->slogan.'%')
                                ->first();

        $member = new OrganizationUser();
        $member->organization_id = $organization->id;
        $member->user_id = $request->user()->id;
        $member->expired_at = Carbon::now()->addDays(2);
        $member->save();

        return response([
            'message' => 'success'
        ], 200);
    }

    public function registerAnyway(Request $request)
    {
        app(OrganizationController::class)->store($request);

        return response([
            'message' => 'success'
        ], 200);
    }
}
