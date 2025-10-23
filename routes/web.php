<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ToolController;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/request',function (Request $request){
    dd($request);
});

Route::get('/redirect',function (){
    return redirect('/');
});

Route::get('/name/{nom}', function ($nom) {
    return $nom;
});

Route::get('/test', function () {
    return view('form');
});


Route::resource('tools', ToolController::class);


Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');

Route::get('/search',[InvoiceController::class,'search'])->name('search');
