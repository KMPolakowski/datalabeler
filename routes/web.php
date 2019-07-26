<?php

use App\Models\PagePiece;

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
Route::post('/events/page_piece/{id}/{labeledBy}' , "Controller@addEventOfPagePiece");

Route::get('/to-label/{author}', "Controller@showPagePieceToBeLabeled");