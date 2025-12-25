<?php

use App\Livewire\CartPage;
use App\Livewire\Documentation;
use App\Livewire\FeaturesPage;
use App\Livewire\ProductCatalog;
use Illuminate\Support\Facades\Route;

Route::get('/', ProductCatalog::class)->name('home');
Route::get('/cart', CartPage::class)->name('cart');
Route::get('/features', FeaturesPage::class)->name('features');
Route::get('/docs', Documentation::class)->name('docs');
