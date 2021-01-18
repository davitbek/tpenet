<?php

Route::post('auth/register', 'AuthUserController@register');
Route::post('auth/activate', 'AuthUserController@activate');
Route::post('auth/login', 'AuthUserController@login');
Route::post('auth/login/refresh', 'AuthUserController@refreshToken');
//Route::post('auth/login-by-token', 'AuthUserController@login');
Route::post('auth/social-login', 'AuthUserController@socialLogin');
Route::post('auth/apple-login', 'AuthUserController@appleLogin');
Route::post('auth/password/forgot', 'AuthUserController@forgotPassword');
Route::post('auth/password/reset', 'AuthUserController@resetPassword');
Route::get('auth/user/enet-leagues/favorite', 'Enet\EnetTournamentStageController@userFavoriteLeagues');

Route::middleware(\Api\V1\Http\Middleware\ApiAuth::class)->group(function () {
    // @TODO make route aliases
    // TODO  delete auth/user/
    Route::get('auth/user', 'AuthUserController@getAuthUser');
    Route::put('auth/user/update', 'AuthUserController@updateAuth');
    Route::put('auth/user/update/password', 'AuthUserController@updateAuthPassword');
    Route::delete('auth/user/delete', 'AuthUserController@deleteAuth');
});
