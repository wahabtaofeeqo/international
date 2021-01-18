<?php

namespace App\Http\Controllers\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Language;

use App\Http\Requests\StoreLanguage;

class LanguageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Language::orderBy('name', 'ASC')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLanguage $request)
    {
        $this->authorize('canControlEverything');

        $validated = $request->validated();

        $language = new Language();
        $language->name = $request->name;
        $language->code = $request->code;
        $language->save();

        return response($language, 200);
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
        $this->authorize('canControlEverything');

        $language = Language::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|string|unique:languages,name,'.$language->id,
            'code' => 'required|string|min:2'
        ]);

        $language->name = $request->name;
        $language->code = $request->code;
        $language->save();

        return response($language, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('canControlEverything');

        $language = Language::findOrFail($id);
        $language->delete();

        return response([
            'message' => 'success'
        ], 200);
    }
}
