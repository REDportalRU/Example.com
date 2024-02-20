<?php

    namespace App\Http\Controllers;

    use App\Http\Controllers\News\BannersController;
    use App\Http\Controllers\News\CategoriesController;
    use App\Http\Controllers\News\NewsController;
    use App\Http\Controllers\News\TagsController;
    use Illuminate\Support\Facades\Route;

    /**
     * АДМИНКА
     */
    Route::middleware('auth')->group(function () {
        /**
         * НОВОСТИ - новости
         */
        Route::controller(NewsController::class)
             ->name('news.')
             ->group(function () {
                 // Все новости
                 Route::match(['get', 'post'], '/news/{perPage?}/{filter?}/{activePage?}/{category?}', 'index')
                      ->where(['perPage' => '[0-9]+', 'filter' => '[0-9]+', 'category' => '[0-9]+'])
                      ->name('index');
                 // Обновление статуса переключателя публикации
                 Route::post('/news/updatePubliched/{id}/{published}', 'updatePubliched');
                 // Добавление новости
                 Route::get('/news/add', 'add')->name('add');
                 Route::post('/news/add', 'save')->name('save');
                 // Редактирование новости
                 Route::get('/news/update/{id}', 'update')->where(['id' => '[0-9]+'])->name('update');
                 Route::post('/news/update/{id}', 'store')->where(['id' => '[0-9]+'])->name('store');
                 // Удаление новости
                 Route::post('/news/delete/{id}', 'delete')->where(['id' => '[0-9]+'])->name('delete');
             });
        /**
         * НОВОСТИ - теги
         */
        Route::controller(TagsController::class)
             ->name('tags.')
             ->group(function () {
                 // Все теги
                 Route::match(['get', 'post'], '/tags/{perPage?}/{filter?}/{activePage?}', 'index')->where(['perPage' => '[0-9]+', 'filter' => '[0-9]+',])->name('index');
                 // Обновление статуса переключателя публикации
                 Route::post('/tag/updatePubliched/{id}/{published}', 'updatePubliched');
                 // Добавление тега
                 Route::get('/tag/add', 'add')->name('add');
                 Route::post('/tag/add', 'save')->name('save');
                 // Редактирование тега
                 Route::get('/tag/update/{id}', 'update')->where(['id' => '[0-9]+'])->name('update');
                 Route::post('/tag/update/{id}', 'store')->where(['id' => '[0-9]+'])->name('store');
                 // Удаление тега
                 Route::post('/tag/delete/{id}', 'delete')->where(['id' => '[0-9]+'])->name('delete');
             });
        /**
         * НОВОСТИ - категории
         */
        Route::controller(CategoriesController::class)
             ->name('categories.')
             ->group(function () {
                 // Все категории
                 Route::match(['get', 'post'], '/categories/{perPage?}/{filter?}/{activePage?}', 'index')->where(['perPage' => '[0-9]+', 'filter' => '[0-9]+',])->name('index');
                 // Обновление статуса переключателя публикации
                 Route::post('/category/updatePubliched/{id}/{published}', 'updatePubliched');
                 // Обновление сортировки категорий
                 Route::post('/categories/sort', 'sortCategories');
                 // Добавление категории
                 Route::get('/category/add', 'add')->name('add');
                 Route::post('/category/add', 'save')->name('save');
                 // Редактирование категории
                 Route::get('/category/update/{id}', 'update')->where(['id' => '[0-9]+'])->name('update');
                 Route::post('/category/update/{id}', 'store')->where(['id' => '[0-9]+'])->name('store');
                 // Удаление категории
                 Route::post('/category/delete/{id}', 'delete')->where(['id' => '[0-9]+'])->name('delete');
             });
        /**
         * НОВОСТИ - банеры
         */
        Route::controller(BannersController::class)
             ->name('banners.')
             ->group(function () {
                 // Все банеры
                 Route::match(['get', 'post'], '/banners', 'index')->name('index');
                 // Обновление статуса переключателя публикации
                 Route::post('/banners/update', 'store')->name('store');
             });
    });