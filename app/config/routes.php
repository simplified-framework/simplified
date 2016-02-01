<?php

use Simplified\Http\Route;

/* FRONTEND INTERFACE */
// List all posts with pagination
Route::get('/{page?}', 'BlogPageController@showPage')->conditions('page', '[\d]+');

// list posts with tag
Route::get('/tags/{name}', 'TagController@showTag')->conditions('name', '[0-9a-zA-Z-]+');

// show tag error
Route::get('/tags', 'TagController@showError');

// list posts in category
Route::get('/category/{name}', 'CategoryController@showCategory')->conditions('name', '[0-9a-z\-]+');

// show category error
Route::get('/category', 'CategoryController@showError');

// Show post with slug
Route::get('/{slug?}', 'BlogPostController@showPost')->conditions('slug', '[A-Za-z0-9\-]+');

// List posts with year and month with pagination
Route::get('/{year}/{month}', 'ArchiveController@showPage')->conditions(array('year' => '\d+', 'month' => '\d+'));

// local dummy image creation
Route::get('/dummyimage/{size}/{background}/{foreground}/image.png', 'DummyImageController@showImage')
    ->conditions(array('size' => '[xX\d]+', 'background' => '[a-zA-Z0-9]+','foreground' => '[a-zA-Z0-9]+'));

/* ADMIN INTERFACE */
Route::get('/admin', 'Admin\PostController@index');

// Admin categories interface
Route::get('/admin/categories', 'Admin\CategoryController@index');
Route::get('/admin/categories/create', 'Admin\CategoryController@create');
Route::get('/admin/categories/edit/{id}', 'Admin\CategoryController@edit')->conditions('id', '[0-9]+');
Route::get('/admin/categories/remove/{id}', 'Admin\CategoryController@remove')->conditions('id', '[0-9]+');
Route::post('/admin/categories/save/{id?}', ['as' => 'categories.save', 'uses' => 'Admin\CategoryController@save'])->conditions('id', '[0-9]+');

// Admin tags interface
Route::get('/admin/tags', 'Admin\TagController@index');
Route::get('/admin/tags/remove/{id}', 'Admin\TagController@remove')->conditions('id', '[0-9]+');

// Admin posts interface
Route::get('/admin/posts', 'Admin\PostController@index');
Route::get('/admin/posts/create', 'Admin\PostController@create');
Route::get('/admin/posts/edit/{id}', 'Admin\PostController@edit')->conditions('id', '[0-9]+');
Route::get('/admin/posts/remove/{id}', 'Admin\PostController@remove')->conditions('id', '[0-9]+');
Route::post('/admin/posts/save/{id?}', ['as' => 'posts.save', 'uses' => 'Admin\PostController@save'])->conditions('id', '[0-9]+');

// Admin galleries interface
Route::get('/admin/galleries', 'Admin\GalleriesController@index');
Route::get('/admin/galleries/create', 'Admin\GalleriesController@create');
Route::get('/admin/galleries/edit/{id}', 'Admin\GalleriesController@edit')->conditions('id', '[0-9]+');
Route::get('/admin/galleries/remove/{id}', 'Admin\GalleriesController@remove')->conditions('id', '[0-9]+');
Route::post('/admin/galleries/save/{id?}', ['as' => 'galleries.save', 'uses' => 'Admin\GalleriesController@save'])->conditions('id', '[0-9]+');
Route::post('/admin/galleries/uploadImage/{id?}', ['as' => 'galleries.uploadImage', 'uses' => 'Admin\GalleriesController@uploadImage'])->conditions('id', '[0-9]+');
Route::delete('/admin/galleries/deleteImage/{id?}', ['as' => 'galleries.deleteImage', 'uses' => 'Admin\GalleriesController@deleteImage'])->conditions('id', '[0-9]+');
Route::get('/admin/galleries/editImage/{id?}', ['as' => 'galleries.editImage', 'uses' => 'Admin\GalleriesController@editImage'])->conditions('id', '[0-9]+');
Route::post('/admin/galleries/updateImage/{id?}', ['as' => 'galleries.updateImage', 'uses' => 'Admin\GalleriesController@updateImage'])->conditions('id', '[0-9]+');

// Admin files interface
Route::get('/admin/files', 'Admin\FilesController@index');
Route::get('/admin/files/create', 'Admin\FilesController@create');
Route::post('/admin/files/upload', ['as' => 'files.upload', 'uses' => 'Admin\FilesController@upload']);
Route::get('/admin/files/remove/{id}', 'Admin\FilesController@remove')->conditions('id', '[0-9]+');