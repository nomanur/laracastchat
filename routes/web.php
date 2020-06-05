<?php

use App\Project;
use Illuminate\Support\Facades\Route;
use  App\Events\TaskCreated;
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

Route::get('/', function () {
    return view('welcome');
});


ROute::get('/projects/{project}', function(Project $project){
	$project->load('tasks');
	return view('projects.show', compact('project'));
});


Route::get('/api/projects/{project}', function(Project $project){
	return $project->tasks->pluck('body');
});
			 
Route::post('/api/projects/{project}/tasks', function(Project $project){
	
	$task = $project->tasks()->create(request(['body']));

	event(new TaskCreated($task));

	return $task;
});

Auth::routes();


Route::get('logout', function(){
	auth()->logout();
});

Route::get('/home', 'HomeController@index')->name('home');
