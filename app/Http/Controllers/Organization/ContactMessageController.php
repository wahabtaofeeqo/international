<?php

namespace App\Http\Controllers\Organization;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreContactMessage;

use App\Models\OrganizationContactMessage;

class ContactMessageController extends Controller
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

        $this->authorize('canControlOrganization');
        
        $contact_messages = OrganizationContactMessage::where('organization_id', Auth::guard('api')->user()->organization_id)->get();

        return response($contact_messages, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContactMessage $request)
    {
        $contact_message = new OrganizationContactMessage();
        $contact_message->name = $request->name;
        $contact_message->email = $request->email;
        $contact_message->subject = $request->subject;
        $contact_message->message = $request->message;
        $contact_message->organization_id = $request->organization_id;
        $contact_message->save();

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
        
        $contact_message = OrganizationContactMessage::findOrFail($id);
        $contact_message->delete();

        return response([
            'message' => 'Success'
        ], 200);
    }
}
