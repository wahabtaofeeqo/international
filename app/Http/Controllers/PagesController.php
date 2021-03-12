<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\Organization;
use App\Imports\CityImport;
use Excel;
use Illuminate\Support\Facades\Auth;

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0); 

class PagesController extends Controller
{
    // Homepage
    public function index()
    {

        $posts = array();
        $id = 1;
        $organization = Organization::find($id);

        if ($organization) {
            $posts = $organization->posts()
                ->withCount('comments')
                ->where('status', 1)
                ->latest()
                ->paginate(3);
        }

    	return view('pages.index')->with('posts', $posts);
    }
    
    public function donate()
    {
        return view('pages.donate');
    }
    public function majorMouseTestingProgram()
    {
        return view('pages.projects.major-mouse-testing-program');
    }


    // About pages
    public function manifesto()
    {
        return view('pages.about.manifesto');
    }

    public function history()
    {
        return view('pages.about.history');
    }

    public function boardMembers()
    {
        return view('pages.about.boardMembers');
    }

    public function advisoryBoard()
    {
        return view('pages.about.advisoryBoard');
    }

    public function organizationalCharts() {
        return view('pages.about.organizationalCharts');
    }

    public function report() {
        return view('pages.about.report');
    }

    public function organization($id) {
    	$organization = Organization::findOrFail($id);
    	return view('pages.organization.index')->with('organization', $organization);
    }

    public function unsubscribe($id) {
        $organization = Organization::findOrFail($id);
        return $organization;
    }

    public function test() {

        //print_r(Auth::user());

        echo Auth::user()->city;
        return view('import');
    }

    public function testPost(Request $request) {
        
        $request->validate([
            'file' => 'required']);

        Excel::import(new CityImport, $request->file('file'));

        return "Done";
    }
}