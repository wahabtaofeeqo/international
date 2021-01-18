<?php

namespace App\Http\Controllers\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use App\Models\OrganizationUser;
use App\Models\OrganizationSubscription;
use App\Models\OrganizationContactMessage;
use App\Models\Post;

class CounterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    public function members()
    {
    	return OrganizationUser::where('organization_id', Auth::user()->organization->id)->where('verified', 1)->count();
    }

    public function articles()
    {
    	$count = 0;

        if ($this->authorize('canWorkOnPost')) {
            foreach (Auth::user()->organization->users as $user) {
                if (count($user->posts)) {
                    $count += Post::where('user_id', $user->id)->count();
                }
            }
        }
        else {
            $count += Post::with('user')->where('user_id', Auth::user()->id)->count();
        }

        return $count;
    }

    public function subscribers()
    {
    	return OrganizationSubscription::where('organization_id', Auth::user()->organization->id)->count();
    }

    public function messages()
    {
    	return OrganizationContactMessage::where('organization_id', Auth::user()->organization->id)->count();
    }

    public function requests()
    {
        return OrganizationUser::where('organization_id', Auth::user()->organization->id)
        ->where('verified', 0)
        ->count();
    }

    public function published()
    {
        $count = 0;

        if ($this->authorize('canWorkOnPost')) {
            foreach (Auth::user()->organization->users as $user) {
                if (count($user->posts)) {
                    $count += Post::where('user_id', $user->id)->where('status', 1)->count();
                }
            }
        }
        else {
            $count += Post::with('user')->where('user_id', Auth::user()->id)->where('status', 1)->count();
        }

        return $count;
    }

    public function draft()
    {
        $count = 0;

        if ($this->authorize('canWorkOnPost')) {
            foreach (Auth::user()->organization->users as $user) {
                if (count($user->posts)) {
                    $count += Post::where('user_id', $user->id)->where('status', 0)->count();
                }
            }
        }
        else {
            $count += Post::with('user')->where('user_id', Auth::user()->id)->where('status', 0)->count();
        }

        return $count;
    }
}
