<?php

use App\Models\Task;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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
//llistat de tasks

Route::get('/', function () {
    $tasks = Task::orderBy('created_at', 'asc')->get();
    $categories = Category::all();


    return view('tasks', [
        'tasks' => $tasks,
        'categories' => $categories
    ]);
});

//llistat de categories

Route::get('/cats', function (){
    $categories = Category::orderBy('created_at', 'asc')->get();

    return view('categories', [
        'categories' => $categories
    ]);
});

//llistat de tasks per categories 

Route::get('/catlist', function (){
    $cats = Category::all();

    return view('catlist', [
        'cats' => $cats
    ]);
});

/**
 * Add New Task
 */
Route::post('/task', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'name' => 'required|max:55',
    ]);

    if ($validator->fails()) {
        return redirect('/')
            ->withInput()
            ->withErrors($validator);
    }
    $task = new Task;
    $task->name = $request->name;
    $task->cat_id = $request->cat_name;
    $task->save();

    return redirect('/');
});

Route::post('/category', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'name' => 'required|max:55',
    ]);

    if ($validator->fails()) {
        return redirect('/')
            ->withInput()
            ->withErrors($validator);
    }
    $category = new Category;
    $category->name = $request->name;
    $category->save();

    return redirect('/cats');
});

/**
 * Delete Task
 */
Route::delete('/task/{task}', function (Task $task) {
    $task->delete();

    return redirect('/');
});

Route::delete('/category/{category}', function (Category $category) {
    $category->delete();

    return redirect('/');
});
