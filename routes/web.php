<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => env('ADMIN_URL'), 'middleware' => ['web']], function () use ($router) {
    $router->get('login', ['uses' => 'App\Http\Controllers\Admin\AccessAdminController@getLogin', 'middleware' => ['adminHaveLogin']])->name('admin.login');
    $router->post('login', ['uses' => 'App\Http\Controllers\Admin\AccessAdminController@postLogin', 'middleware' => ['adminHaveLogin']])->name('admin.login.post');
    $router->get('logout', ['uses' => 'App\Http\Controllers\Admin\AccessAdminController@doLogout'])->name('admin.logout');

    $router->group(['middleware' => ['adminLogin', 'App\Http\Middleware\preventBackHistory']], function () use ($router) {

        $router->group(['prefix' => 'profile'], function () use ($router) {
            $router->get('edit', ['uses'=>'App\Http\Controllers\Admin\ProfileController@getProfile'])->name('admin.get_profile');
            $router->post('edit', ['uses'=>'App\Http\Controllers\Admin\ProfileController@postProfile'])->name('admin.post_profile');
            $router->get('password', ['uses'=>'App\Http\Controllers\Admin\ProfileController@getPassword'])->name('admin.get_password');
            $router->post('password', ['uses'=>'App\Http\Controllers\Admin\ProfileController@postPassword'])->name('admin.post_password');
            $router->get('/', ['uses'=>'App\Http\Controllers\Admin\ProfileController@profile'])->name('admin.profile');
        });

        $router->group(['middleware' => ['adminAccessPermission']], function () use ($router) {
            $listRouter = [
                'App\Http\Controllers\Admin\SettingsController' => 'settings',
                'App\Http\Controllers\Admin\AdminController' => 'admin',
                'App\Http\Controllers\Admin\RoleController' => 'role',
                'App\Http\Controllers\Admin\PositionController' => 'position',
                'App\Http\Controllers\Admin\KaryawanController' => 'karyawan',
                'App\Http\Controllers\Admin\KaryawanKarirController' => 'karyawan_karir',
                'App\Http\Controllers\Admin\UploadAbsensiController' => 'upload-absensi',
                'App\Http\Controllers\Admin\UploadLemburController' => 'upload-lembur',
                'App\Http\Controllers\Admin\SalaryController' => 'salary',
                'App\Http\Controllers\Admin\tunjanganBerkalaController' => 'tunj-berkala',
                'App\Http\Controllers\Admin\ptkpController' => 'ptkp',
            ];

            foreach ($listRouter as $controller => $linkName) {
                switch ($linkName) {
                    case 'upload-absensi':
                        $router->get($linkName . '/create2', $controller.'@create2')->name('admin.' . $linkName . '.create2');
                        $router->post($linkName . '/store2', $controller.'@store2')->name('admin.' . $linkName . '.store2');
                        break;
                    case 'upload-lembur':
                        $router->get($linkName . '/create2', $controller.'@create2')->name('admin.' . $linkName . '.create2');
                        $router->post($linkName . '/store2', $controller.'@store2')->name('admin.' . $linkName . '.store2');
                        break;
                    case 'karyawan':
                        $router->get($linkName . '/import', $controller.'@import')->name('admin.' . $linkName . '.import');
                        $router->post($linkName . '/storeimport', $controller.'@storeimport')->name('admin.' . $linkName . '.storeimport');
                        break;
                    case 'salary':
                        $router->get($linkName . '/import', $controller.'@import')->name('admin.' . $linkName . '.import');
                        $router->post($linkName . '/storeimport', $controller.'@storeimport')->name('admin.' . $linkName . '.storeimport');
                        break;

                }    
                $router->get($linkName . '/data', $controller . '@dataTable')->name('admin.' . $linkName . '.dataTable');
                $router->resource($linkName, $controller, ['as' => 'admin']);
            }

        });

        $router->get('/', ['uses' => 'Admin\DashboardController@dashboard'])->name('admin');

    });    

});
