<?php

namespace App\Http\Controllers\Organization;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

use App\Models\Organization;
use App\Models\Newsletter;
use App\Models\Language;
use App\Models\City;

use App\Mail\SendNewsletter;

use App\Jobs\DeployNewsletter;

class NewsletterController extends Controller
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
        $this->authorize('canWorkOnNewsletter');

        $newsletters = Auth::user()->organization->newsletters;

        return response($newsletters, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('canWorkOnNewsletter');

        $newsletter = new Newsletter();
        $newsletter->subject = $request->subject;
        $newsletter->content = $request->content;
        $newsletter->organization_id = $request->user()->organization->id;
        $newsletter->save();

        return response([
            'message' => 'success'
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
        $this->authorize('canWorkOnNewsletter');

        $newsletter = Newsletter::findOrFail($id);
        $newsletter->subject = $request->subject;
        $newsletter->content = $request->content;
        $newsletter->save();

        return response([
            'message' => 'success'
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
        $this->authorize('canWorkOnNewsletter');

        $newsletter = Newsletter::findOrFail($id);
        $newsletter->delete();

        return response([
            'message' => 'Success'
        ], 200);
    }

    /*
     * Test mail by sending to request->user
    */
    public function testNewsletter(Request $request)
    {
        $this->authorize('canWorkOnNewsletter');

        $newsletter = new Newsletter();
        $newsletter->subject = $request->subject;
        $newsletter->content = $request->content;
        $newsletter->organization_id = $request->user()->organization->id;

        Mail::to($request->user())
            ->send(new SendNewsletter($newsletter));

        return response([
            'message' => 'success'
        ], 200);
    }

    /*
     * Save and test mail by sending to request->user
    */
    public function saveAndTestNewsletter(Request $request)
    {
        $this->authorize('canWorkOnNewsletter');

        $newsletter = new Newsletter();
        $newsletter->subject = $request->subject;
        $newsletter->content = $request->content;
        $newsletter->organization_id = $request->user()->organization->id;
        $newsletter->save();

        Mail::to($request->user())
            ->send(new SendNewsletter($newsletter));

        return response([
            'message' => 'success'
        ], 200);
    }

    /*
     * Update and test mail by sending to request->user
    */
    public function updateAndTestNewsletter(Request $request, $id)
    {
        $this->authorize('canWorkOnNewsletter');

        $newsletter = Newsletter::findOrFail($id);
        $newsletter->subject = $request->subject;
        $newsletter->content = $request->content;
        $newsletter->save();

        Mail::to($request->user())
            ->send(new SendNewsletter($newsletter));

        return response([
            'message' => 'success'
        ], 200);
    }

    /*
     * Dispatch a newsletter
    */
    public function dispatchNewsletter(Request $request, $id)
    {
        $this->authorize('canControlOrganization');

        $newsletter = Newsletter::findOrFail($id);

        // Update newsletter's target
        $newsletter->target = '';

        abort_unless($request->input('members.select') || $request->input('subscribers.select'), 400);

        // For members
        if ($request->input('members.select')) {
            $newsletter->target .= 'Members : Selected<br>';

            // All languages | Specific Language
            if ($request->input('members.language') == 0) {
                $newsletter->target .= 'Languages : All<br>';
            }
            else {
                $newsletter->target .= 'Language : ';

                $language = Language::findOrFail($request->input('members.language'));

                $newsletter->target .= $language->name.'<br>';
            }

            // All cities | Specifics
            if (!count($request->input('members.cities'))) {
                $newsletter->target .= 'Cities : All<br>';
            }
            else {
                $newsletter->target .= 'Cities : ';

                foreach ($request->input('members.cities') as $city_id) {
                    $city = City::findOrFail($city_id);

                    $newsletter->target .= $city->name.', ';
                }

                $newsletter->target .= '<br>';
            }

            $newsletter->target .= '<br>';
        }

        // For subscribers
        if ($request->input('subscribers.select')) {
            $newsletter->target .= 'Subscribers : Selected<br>';

            // All languages | Specific Language
            if ($request->input('subscribers.language') == 0) {
                $newsletter->target .= 'Languages : All<br>';
            }
            else {
                $newsletter->target .= 'Language : ';

                $language = Language::findOrFail($request->input('subscribers.language'));

                $newsletter->target .= $language->name.'<br>';
            }
        }

        $newsletter->save();
        
        // Deploy the newsletter job
        DeployNewsletter::dispatch($newsletter)->delay(now()->addSeconds(5));

        return response($newsletter, 200);
    }
}
