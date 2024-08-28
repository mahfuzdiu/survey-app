<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionController;

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


Route::get('/', [HomeController::class, 'welcome'])->name('welcome');

Auth::routes();
Route::resource('/questions', QuestionController::class)->middleware('auth');
Route::get('/questions/{id}/update-status', [QuestionController::class, 'updateQuestionStatus'])->name('questions.status');
Route::post('/questions/vote', [QuestionController::class, 'submitPublicVote'])->name('submit.vote');
Route::get('/questions/{id}/watch-graph', [QuestionController::class, 'watchGraph'])->name('questions.watch-graph');
