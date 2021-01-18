<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('/test', function (\Illuminate\Http\Request $request) {
	$data = $request->all();

	return ['data' => $data];
});

Route::get('/', 'PagesController@index')->name('index');
Route::get('/donate', 'PagesController@donate')->name('donate');
Route::get('/major-mouse-testing-program', 'PagesController@majorMouseTestingProgram')->name('projects.majorMouseTestingProgram');
Route::prefix('about')->group(function () {
	Route::get('/manifesto', 'PagesController@manifesto')->name('about.manifesto');
	Route::get('/history', 'PagesController@history')->name('about.history');
	Route::get('/boardMembers', 'PagesController@boardMembers')->name('about.boardMembers');
	Route::get('/advisoryBoard', 'PagesController@advisoryBoard')->name('about.advisoryBoard');
	Route::get('/organizationalCharts', 'PagesController@organizationalCharts')->name('about.organizationalCharts');
	Route::get('/report', 'PagesController@report')->name('about.report');

});

/**
	* Organization under the company
*/
Route::get('/organization/{id}', 'PagesController@organization')->where('id', '[0-9]+')->name('organization.index');
Route::get('/organization/{id}/register', 'PagesController@organization')->where('id', '[0-9]+')->name('organization.register');
Route::get('/organization/{id}/post/{post_id}', 'PagesController@organization')->where([
	'id', '[0-9]+',
	'post_id', '[0-9]+',
]);

Route::post('/organization/register', 'Organization\EntryController@register');
Route::post('/organization/join', 'Organization\EntryController@join');
Route::post('/organization/register-anyway', 'Organization\EntryController@registerAnyway');

Route::get('/unsubscribe/{id}', 'PagesController@unsubscribe')->where('id', '[0-9]+')->name('unsubscribe');

// Member registration into organization
Route::post('/organization_members/register', 'Organization\OrganizationUserController@register');

/*
	* Users
*/
Route::middleware(['role:user'])->group(function () {
	Route::prefix('user')->group(function () {
		Route::get('/', 'UserController@index')->name('user');

		Route::get('/{path}', 'UserController@index')->where([
			'/path' => '([A-Z\d-\/_.]+)?',
		]);
	});
});

/*
	* Editors
*/
Route::middleware(['role:editor'])->group(function () {
	Route::prefix('editor')->group(function () {
		Route::get('/', 'EditorController@index')->name('editor');

		Route::get('/{path}', 'EditorController@index')->where([
			'/path' => '([A-Z\d-\/_.]+)?',
		]);

		Route::get('/{path}/{path2}', 'EditorController@index')->where([
			'/path' => '([A-Z\d-\/_.]+)?',
			'/path2' => '([A-Z\d-\/_.]+)?',
		]);
	});
});

/*
	* Admin
*/
Route::middleware(['role:admin'])->group(function () {
	Route::prefix('admin')->group(function () {
		Route::get('/', 'AdminController@index')->name('admin');

		Route::get('/{path}', 'AdminController@index')->where([
			'/path' => '([A-Z\d-\/_.]+)?',
		]);

		Route::get('/{path}/{path2}', 'AdminController@index')->where([
			'/path' => '([A-Z\d-\/_.]+)?',
			'/path2' => '([A-Z\d-\/_.]+)?',
		]);
	});
});

/*
	* Super
*/
Route::middleware(['role:super'])->group(function () {
	Route::prefix('super')->group(function () {
		Route::get('/', 'SuperController@index')->name('super');

		Route::get('/{path}', 'SuperController@index')->where([
			'/path' => '([A-Z\d-\/_.]+)?',
		]);

		Route::get('/{path}/{path2}', 'SuperController@index')->where([
			'/path' => '([A-Z\d-\/_.]+)?',
			'/path2' => '([A-Z\d-\/_.]+)?',
		]);
	});
});

Auth::routes();

Route::get('/register/{path}', function() {
	return view('auth.register');
})->where('/path', '([A-Z\d-\/_.]+)?')->middleware('auth');

Route::get('/home', 'HomeController@index')->name('home');
