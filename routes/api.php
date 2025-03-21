<?php

use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// recuperer la liste des postes 
Route::get('/posts', [PostController::class, 'index']); 

// Ajouter un poste 

Route::post('/posts/create', [PostController::class, 'store']); 

// Editer un poste 

Route::put('/posts/edit/{post}', [PostController::class, 'update']);

// supprimer un post
 Route::delete('/posts/{post}', [PostController::class, 'delete']);
