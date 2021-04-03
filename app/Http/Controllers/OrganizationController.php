<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Organization;

class OrganizationController extends Controller
{
    public function index($id)
    {
    	$organization = Organization::with('city', 'city.region', 'city.region.country', 'city.country')->findOrFail($id);

    	return response($organization, 200);
    }
}
