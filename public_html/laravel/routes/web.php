<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;
use App\Http\Middleware\IsAdmin;
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

// Route::get('login')->uses('App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');

Route::get('/', [App\Http\Controllers\CampurController::class, 'index']);

Route::post('userauth', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::get('buatakun', [App\Http\Controllers\Auth\RegisterController::class, 'index']);
Route::get('lupapassword', [App\Http\Controllers\CampurController::class, 'lupapassword']);
// Route::post('storeregister', [App\Http\Controllers\Auth\RegisterController::class, 'storeregister']);
Route::post('storeregister', [App\Http\Controllers\CampurController::class, 'storeregister']);
Route::post('resetpassword', [App\Http\Controllers\CampurController::class, 'resetpassword']);
Route::get('aktivasi/{id}', [App\Http\Controllers\CampurController::class, 'aktivasi']);

Route::get('/home', [App\Http\Controllers\ProfilController::class, 'index'])->name('home');

Route::get('rankingpaket/{id}', [App\Http\Controllers\UserController::class, 'rankingpaket']);
Route::get('rankingpaketkec/{id}', [App\Http\Controllers\UserController::class, 'rankingpaketkec']);



Route::middleware([IsAdmin::class])->group(function () {
    Route::get('/profil', [App\Http\Controllers\ProfilController::class, 'profil']);
    Route::post('/updateUserProfil', [App\Http\Controllers\ProfilController::class, 'update']);
    Route::post('/updateUserPassword', [App\Http\Controllers\ProfilController::class, 'updatepassword']);
    // Kategori Soal
    Route::get('kategorisoal', [App\Http\Controllers\KategoriSoalController::class, 'index']);
    Route::post('storekategorisoal', [App\Http\Controllers\KategoriSoalController::class, 'store']);
    Route::post('/updatekategorisoal/{id}', [App\Http\Controllers\KategoriSoalController::class, 'update']);
    Route::post('/hapuskategorisoal/{id}', [App\Http\Controllers\KategoriSoalController::class, 'destroy']);
    // Kategori Soal Kecermatan
    Route::get('kategorisoalkecermatan', [App\Http\Controllers\KategoriSoalKecermatanController::class, 'index']);
    Route::post('storekategorisoalkecermatan', [App\Http\Controllers\KategoriSoalKecermatanController::class, 'store']);
    Route::post('/updatekategorisoalkecermatan/{id}', [App\Http\Controllers\KategoriSoalKecermatanController::class, 'update']);
    Route::post('/hapuskategorisoalkecermatan/{id}', [App\Http\Controllers\KategoriSoalKecermatanController::class, 'destroy']);
    // Kategori Soal
    Route::get('masterrekening', [App\Http\Controllers\MasterRekeningController::class, 'index']);
    Route::post('storemasterrekening', [App\Http\Controllers\MasterRekeningController::class, 'store']);
    Route::post('/updatemasterrekening/{id}', [App\Http\Controllers\MasterRekeningController::class, 'update']);
    Route::post('/hapusmasterrekening/{id}', [App\Http\Controllers\MasterRekeningController::class, 'destroy']);
    // Master Soal
    Route::get('mastersoal/{idkategori}', [App\Http\Controllers\MasterSoalController::class, 'index']);
    Route::post('storemastersoal', [App\Http\Controllers\MasterSoalController::class, 'store']);
    Route::get('editmastersoal/{idkategori}/{id}', [App\Http\Controllers\MasterSoalController::class, 'edit']);
    Route::post('/updatemastersoal/{id}', [App\Http\Controllers\MasterSoalController::class, 'update']);
    Route::post('/hapusmastersoal/{id}', [App\Http\Controllers\MasterSoalController::class, 'destroy']);
    Route::post('/hapusmastersoalall', [App\Http\Controllers\MasterSoalController::class, 'destroyall']);
    Route::post('importsoal', [App\Http\Controllers\MasterSoalController::class, 'importsoal']);
    // Master Soal Kecermatan
    Route::get('mastersoalkecermatan/{idkategori}', [App\Http\Controllers\MasterSoalKecermatanController::class, 'index']);
    Route::post('storemastersoalkecermatan', [App\Http\Controllers\MasterSoalKecermatanController::class, 'store']);
    Route::post('/updatemastersoalkecermatan/{id}', [App\Http\Controllers\MasterSoalKecermatanController::class, 'update']);
    Route::post('/hapusmastersoalkecermatan/{id}', [App\Http\Controllers\MasterSoalKecermatanController::class, 'destroy']);
    // Dtl Soal Kecermatan
    Route::get('dtlsoalkecermatan/{idmaster}', [App\Http\Controllers\DtlSoalKecermatanController::class, 'index']);
    Route::post('storedtlsoalkecermatan', [App\Http\Controllers\DtlSoalKecermatanController::class, 'store']);
    Route::post('/updatedtlsoalkecermatan/{id}', [App\Http\Controllers\DtlSoalKecermatanController::class, 'update']);
    Route::post('/hapusdtlsoalkecermatan/{id}', [App\Http\Controllers\DtlSoalKecermatanController::class, 'destroy']);
    // Paket Soal Pilihan Ganda
    Route::get('paketsoal', [App\Http\Controllers\PaketSoalController::class, 'index']);
    Route::post('storepaketsoal', [App\Http\Controllers\PaketSoalController::class, 'store']);
    Route::post('/updatepaketsoal/{id}', [App\Http\Controllers\PaketSoalController::class, 'update']);
    Route::post('/hapuspaketsoal/{id}', [App\Http\Controllers\PaketSoalController::class, 'destroy']);
    Route::get('nilaipeserta/{id}', [App\Http\Controllers\PaketSoalController::class, 'nilaipeserta']);
    Route::get('downloadnilai/{id}', [App\Http\Controllers\PaketSoalController::class, 'downloadnilai']);
    Route::get('lihatnilai/{id}', [App\Http\Controllers\PaketSoalController::class, 'lihatnilai']);
    Route::get('downloaddatanilai/{id}', [App\Http\Controllers\PaketSoalController::class, 'downloaddatanilai']);

    // Paket Soal Kecermatan
    Route::get('paketsoalkecermatan', [App\Http\Controllers\PaketSoalKecermatanController::class, 'index']);
    Route::post('storepaketsoalkecermatan', [App\Http\Controllers\PaketSoalKecermatanController::class, 'store']);
    Route::post('/updatepaketsoalkecermatan/{id}', [App\Http\Controllers\PaketSoalKecermatanController::class, 'update']);
    Route::post('/hapuspaketsoalkecermatan/{id}', [App\Http\Controllers\PaketSoalKecermatanController::class, 'destroy']);

    Route::get('paketsoalktg/{id}', [App\Http\Controllers\PaketSoalController::class, 'indexktg']);
    Route::post('storepaketsoalktg', [App\Http\Controllers\PaketSoalController::class, 'storektg']);
    Route::post('/updatepaketsoalktg/{id}', [App\Http\Controllers\PaketSoalController::class, 'updatektg']);
    Route::post('/hapuspaketsoalktg/{id}', [App\Http\Controllers\PaketSoalController::class, 'destroyktg']);

    Route::get('paketsoaldtl/{id}', [App\Http\Controllers\PaketSoalController::class, 'indexdtl']);
    Route::post('storepaketsoaldtl/{idmst}/{idktg}', [App\Http\Controllers\PaketSoalController::class, 'storedtl']);
    Route::post('/updatepaketsoaldtl/{id}', [App\Http\Controllers\PaketSoalController::class, 'updatedtl']);
    Route::post('/hapuspaketsoaldtl/{id}', [App\Http\Controllers\PaketSoalController::class, 'destroydtl']);

    Route::get('paketsoalkecermatandtl/{id}', [App\Http\Controllers\PaketSoalKecermatanController::class, 'indexdtl']);
    Route::post('storepaketsoalkecermatandtl/{idmst}', [App\Http\Controllers\PaketSoalKecermatanController::class, 'storedtl']);
    Route::post('/updatepaketsoalkecermatandtl/{id}', [App\Http\Controllers\PaketSoalKecermatanController::class, 'updatedtl']);
    Route::post('/hapuspaketsoalkecermatandtl/{id}', [App\Http\Controllers\PaketSoalKecermatanController::class, 'destroydtl']);

    // Master Member
    Route::get('mastermember', [App\Http\Controllers\MasterMemberController::class, 'index']);
    Route::post('storemastermember', [App\Http\Controllers\MasterMemberController::class, 'store']);
    Route::post('/updatemastermember/{id}', [App\Http\Controllers\MasterMemberController::class, 'update']);
    Route::post('/hapusmastermember/{id}', [App\Http\Controllers\MasterMemberController::class, 'destroy']);

    // Member Dtl
    Route::get('memberdtl/{idmst}', [App\Http\Controllers\MasterMemberController::class, 'indexdtl']);
    Route::post('storememberdtl', [App\Http\Controllers\MasterMemberController::class, 'storedtl']);
    Route::post('/updatememberdtl/{id}', [App\Http\Controllers\MasterMemberController::class, 'updatedtl']);
    Route::post('/hapusmemberdtl/{id}', [App\Http\Controllers\MasterMemberController::class, 'destroydtl']);
    Route::post('getPaketSoal/{idmst}', [App\Http\Controllers\MasterMemberController::class, 'getPaketSoal']);

    Route::get('/user', [App\Http\Controllers\UserListController::class, 'index']);
    Route::post('/storeuserlist', [App\Http\Controllers\UserListController::class, 'store']);
    Route::post('/updateuserlist/{id}', [App\Http\Controllers\UserListController::class, 'update']);
    Route::post('/hapususerlist/{id}', [App\Http\Controllers\UserListController::class, 'destroy']);
    Route::post('/resetuserpass', [App\Http\Controllers\UserListController::class, 'reset']);

    Route::get('/lihathasilujian/{id}', [App\Http\Controllers\UserListController::class, 'lihathasilujian']);
    Route::get('lihatdetailhasil/{id}', [App\Http\Controllers\UserListController::class, 'lihatdetailhasil']);
    Route::get('lihatdetailhasilkecermatan/{id}', [App\Http\Controllers\UserListController::class, 'lihatdetailhasilkecermatan']);
    Route::get('lihattransaksi/{id}', [App\Http\Controllers\UserListController::class, 'lihattransaksi']);
    Route::post('/updatestatuspembayaran/{id}', [App\Http\Controllers\UserListController::class, 'updatestatuspembayaran']);

    Route::get('template', [App\Http\Controllers\AdminController::class, 'tmp']);
    Route::post('/updatetemplate/{id}', [App\Http\Controllers\AdminController::class, 'updatetmp']);

});

// User
Route::get('paketdetail/{id}', [App\Http\Controllers\UserController::class, 'index']);
Route::get('test', [App\Http\Controllers\UserController::class, 'test']);
Route::post('createorder', [App\Http\Controllers\PaymentController::class, 'createorder']);
Route::get('detailbayar/{id}', [App\Http\Controllers\PaymentController::class, 'detailbayar']);
Route::get('transaksi', [App\Http\Controllers\UserController::class, 'transaksi']);
Route::get('kerjakansoal', [App\Http\Controllers\UserController::class, 'kerjakansoal']);
Route::post('/mulaiujian/{id}', [App\Http\Controllers\UserController::class, 'mulaiujian']);
Route::post('/mulaiujiankecermatan/{id}', [App\Http\Controllers\UserController::class, 'mulaiujiankecermatan']);
Route::get('ujian/{id}', [App\Http\Controllers\UserController::class, 'ujian']);
// Route::get('ujiankecermatan/{id}', [App\Http\Controllers\UserController::class, 'ujiankecermatan']);
Route::post('updatejawaban', [App\Http\Controllers\UserController::class, 'updatejawaban']);
Route::post('updatejawabankecermatan', [App\Http\Controllers\UserController::class, 'updatejawabankecermatan']);
Route::get('hasilujian', [App\Http\Controllers\UserController::class, 'hasilujian']);
Route::post('selesaiujian', [App\Http\Controllers\UserController::class, 'selesaiujian']);
Route::post('selesaiujiankecermatan', [App\Http\Controllers\UserController::class, 'selesaiujiankecermatan']);
Route::post('selesaiujiankecermatanfix', [App\Http\Controllers\UserController::class, 'selesaiujiankecermatanfix']);
Route::get('detailhasil/{id}', [App\Http\Controllers\UserController::class, 'detailhasil']);
Route::get('detailhasilkecermatan/{id}', [App\Http\Controllers\UserController::class, 'detailhasilkecermatan']);

// PDF
Route::get('/exportsoal/{jns}/{id}', [App\Http\Controllers\PDFController::class, 'exportsoal']);


// User List
// Route::get('/userlist', [App\Http\Controllers\UserListController::class, 'index']);
// Route::post('/storeuserlist', [App\Http\Controllers\UserListController::class, 'store']);
// Route::post('/updateuserlist/{id}', [App\Http\Controllers\UserListController::class, 'update']);
// Route::post('/hapususerlist/{id}', [App\Http\Controllers\UserListController::class, 'destroy']);
// Route::post('/resetuserpass', [App\Http\Controllers\UserListController::class, 'reset']);

// User Role
// Route::get('/userrole', [App\Http\Controllers\UserRoleController::class, 'index']);
// Route::post('/storeuserrole', [App\Http\Controllers\UserRoleController::class, 'store']);
// Route::post('/updateuserrole/{id}', [App\Http\Controllers\UserRoleController::class, 'update']);
// Route::post('/hapususerrole/{id}', [App\Http\Controllers\UserRoleController::class, 'destroy']);

Route::post('getKabupaten', [App\Http\Controllers\CampurController::class, 'getKabupaten']);
Route::post('getKecamatan', [App\Http\Controllers\CampurController::class, 'getKecamatan']);
// Auth::routes(); 
// Auth::routes(['login' => false]);       
Auth::routes(['register' => false]);       

// Route::group(['middleware' => 'IsAdmin'], function () {
    
// });



