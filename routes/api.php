<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

Route::prefix('v1/')->group(function() {

    Route::get('status', function() { 
        
        return response()->json(['api_name' => 'apicomlaravel-b7web', 'status' => true], 200);

    });

    Route::post('todo', [TodoController::class, 'create']);
    Route::get('todos', [TodoController::class, 'readAll']);
    Route::get('todo/{id}', [TodoController::class, 'read']);
    Route::put('todo/{id}', [TodoController::class, 'update']);
    Route::delete('todo/{id}', [TodoController::class, 'delete']);

});