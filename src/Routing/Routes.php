<?php
namespace App\Routing;

use App\Controller\IndexController;
use App\Routing\Route;

Route::get("/route1", [IndexController::class, "indexAction"]);
Route::get("/route2", [IndexController::class, "indexJsonAction"]);
Route::get("/route3", [IndexController::class, "indexHtmlAction"]);

Route::get("/route4/{id}", [IndexController::class, "indexJsonAction"]);
Route::get("/route5/{firstId}/{?secondId}", [IndexController::class, "indexJsonAction"]);