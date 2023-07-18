<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Rutele pentru autentificare
Route::post('/login', [App\Http\Controllers\API\UserController::class, 'login']);
Route::post('/register', [App\Http\Controllers\API\UserController::class, 'register']);


// Rutele pentru users
Route::middleware(['auth:api'])->group(function () {

    // List Users
    Route::middleware(['scope:admin,basic'])->get('/users', [App\Http\Controllers\API\UserController::class, 'getUsers']);

    // Add User
    Route::middleware(['scope:admin'])->post('/user', [App\Http\Controllers\API\UserController::class, 'addUser']);

    // Edit User
    Route::middleware(['scope:admin'])->post('/user/{userId}', [App\Http\Controllers\API\UserController::class, 'editUser']);

    // Delete User
    Route::middleware(['scope:admin'])->delete('/user/{userId}', [App\Http\Controllers\API\UserController::class, 'deleteUser']);

    // Modificare basic user in admin
    Route::middleware(['scope:admin'])->post('/admin/{userId}', [App\Http\Controllers\API\UserController::class, 'makeAdmin']);
});


//Ruta pentru trimitere comenzii, inclusiv trimiterea de email
Route::post('send-order', [App\Http\Controllers\OrderController::class, 'sendOrder']);
//Ruta pentru obtinerea comenzilor unui client
Route::get('orders/{userId}', [App\Http\Controllers\OrderController::class, 'getOrders']);
//Ruta pentru obtinerea produselor corespunzatoare unei comenzi
Route::get('order/{orderId}', [App\Http\Controllers\OrderController::class, 'getOrder']);


// Rutele pentru categori
Route::get('/category', [App\Http\Controllers\CategoryController::class, 'getAll']);

// Rutele speciale pentru categori
Route::middleware(['auth:api'])->group(function () {

    // List Categories
    //Route::middleware(['scope:admin,basic'])->get('/category', [App\Http\Controllers\CategoryController::class, 'getAll']);

    // Add Category
    Route::middleware(['scope:admin'])->post('/category', [App\Http\Controllers\CategoryController::class, 'addCategory']);

    // Edit Category
    Route::middleware(['scope:admin'])->post('/category/{categoryId}', [App\Http\Controllers\CategoryController::class, 'editCategory']);

    // Delete Category
    Route::middleware(['scope:admin'])->delete('/category/{categoryId}', [App\Http\Controllers\CategoryController::class, 'deleteCategory']);
});


// Rutele pentru produse
Route::get('/products', [App\Http\Controllers\ProductController::class, 'getAll']);
Route::get('/products/{categoryId}', [App\Http\Controllers\ProductController::class, 'getProducts']);
Route::get('/product/{productId}', [App\Http\Controllers\ProductController::class, 'getProduct']);

// Rutele speciale pentru produse
Route::middleware(['auth:api'])->group(function () {

    // List Products
    //Route::middleware(['scope:admin,basic'])->get('/products', [App\Http\Controllers\ProductController::class, 'getAll']);

    // Add Product
    Route::middleware(['scope:admin'])->post('/product', [App\Http\Controllers\ProductController::class, 'addProduct']);

    // Edit Product
    Route::middleware(['scope:admin'])->post('/product/{productId}', [App\Http\Controllers\ProductController::class, 'editProduct']);

    // Delete Product
    Route::middleware(['scope:admin'])->delete('/product/{productId}', [App\Http\Controllers\ProductController::class, 'deleteProduct']);
});


Route::get('/', function () {
    return view('welcome');
});