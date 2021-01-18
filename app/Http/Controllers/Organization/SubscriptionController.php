<?php

namespace App\Http\Controllers\Organization;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use App\Models\OrganizationSubscription;

class SubscriptionController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth:api')->except('store');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('canWorkOnSubscription');

        $subscriptions = OrganizationSubscription::with('language')->where('organization_id', Auth::guard('api')->user()->organization->id)->get();

        return response($subscriptions, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:organization_subscriptions,email,'.$request->organization_id,
            'language_id' => 'required'
        ], [
            'email.unique' => 'You are already subscribed. Thanks though :)',
            'language_id.required' => 'Please select a language'
        ]);

        $subscription = new OrganizationSubscription();
        $subscription->email = $request->email;
        $subscription->language_id = $request->language_id;
        $subscription->organization_id = $request->organization_id;
        $subscription->save();

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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
        
        $subscription = OrganizationSubscription::findOrFail($id);
        $subscription->delete();

        return response([
            'message' => 'Success'
        ], 200);
    }

    /*
     * Get languages of all subscribers in the organization
    */
    public function languages()
    {        
        $languages = [];

        $language_ids = OrganizationSubscription::where('organization_id', Auth::guard('api')->user()->organization->id)
        ->distinct()->get('language_id');

        foreach ($language_ids as $id) {
            $language = \App\Models\Language::findOrFail($id);

            array_push($languages, $language);
        }

        $languages = collect($languages)->collapse();

        return response($languages, 200);
    }
}
