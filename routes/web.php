<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\DiscordAuthController;
use App\Http\Controllers\ClassementController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\ReglementController;
use App\Http\Controllers\WikiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Pages publiques
|--------------------------------------------------------------------------
*/

Route::get('/', HomeController::class)->name('home');
Route::get('/wiki', WikiController::class)->name('wiki');
Route::get('/reglement', ReglementController::class)->name('reglement');
Route::get('/classement', ClassementController::class)->name('classement');

/*
|--------------------------------------------------------------------------
| Inscription
|--------------------------------------------------------------------------
*/

Route::get('/inscription', [InscriptionController::class, 'show'])->name('inscription');
Route::post('/inscription', [InscriptionController::class, 'store'])->name('inscription.store');

/*
|--------------------------------------------------------------------------
| Authentification Discord
|--------------------------------------------------------------------------
*/

Route::get('/api/auth/discord', [DiscordAuthController::class, 'redirect'])->name('auth.discord');
Route::get('/api/auth/callback/discord', [DiscordAuthController::class, 'callback'])->name('auth.discord.callback');
Route::match(['get', 'post'], '/api/auth/logout', [DiscordAuthController::class, 'logout'])->name('auth.logout');

/*
|--------------------------------------------------------------------------
| Panel admin
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');

    Route::post('/teams/{team}/accept', [AdminController::class, 'acceptTeam'])->name('teams.accept');
    Route::post('/teams/{team}/reject', [AdminController::class, 'rejectTeam'])->name('teams.reject');
    Route::post('/teams/{team}/unlist', [AdminController::class, 'unlistTeam'])->name('teams.unlist');
    Route::post('/teams/{team}/status', [AdminController::class, 'setTeamStatus'])->name('teams.status');
    Route::post('/teams/{team}/points', [AdminController::class, 'setPoints'])->name('teams.points');
    Route::post('/teams/{team}/delete', [AdminController::class, 'deleteTeam'])->name('teams.delete');

    Route::post('/admins', [AdminController::class, 'addAdmin'])->name('admins.add');
    Route::post('/admins/remove', [AdminController::class, 'removeAdmin'])->name('admins.remove');
});
