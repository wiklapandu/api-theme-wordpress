<?php
/**
* Routes folder
* to create route api
*
* @package HelloElementor
*/

use MI\Bootstrap\Route;

defined( 'ABSPATH' ) || die( "Can't access directly" );


/**
 * TODO:
 *  - figure it out how to create custom request
 *  - problem still hard to find how to convert request default wordpress
 *    into custom request inheritance from request
 * 
 * */ 

// Route::get('/testing', function (\MI\Requests\RequestPost $request) {
//     $request->running();
//     return wp_send_json([
//         'status' => 'success',
//         'message'=> 'Running....'
//     ]);
// })->registered();

Route::prefix('/book')->group(function(Route $route) {
    $route->get('', [\MI\Controllers\NewsController::class, 'index']);

    $route->get('testing-2', [\MI\Controllers\NewsController::class, 'index']);
});