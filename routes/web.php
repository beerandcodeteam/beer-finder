<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('dashboard', App\Livewire\Chat\Chat::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');

    Route::get('beers', \App\Livewire\Beers\Index::class)->name('beers.index');
    Route::get('beers/create', \App\Livewire\Beers\Create::class)
        ->middleware('can:create,App\Models\Beer')
        ->name('beers.create');
    Route::get('beers/{beer}', \App\Livewire\Beers\Update::class)
        ->middleware('can:update,beer')
        ->name('beers.update');

    Route::get('stores', \App\Livewire\Store\Index::class)->name('stores.index');
    Route::get('stores/create', \App\Livewire\Store\Create::class)->name('stores.create');
    Route::get('stores/{store}', \App\Livewire\Store\Update::class)
        ->middleware('can:update,store')
        ->name('stores.update');
});
