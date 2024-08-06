<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;

Route::get('/', [BookingController::class, 'index'])->name('home');
Route::get('/pilih-jadwal', [BookingController::class, 'showPilihJadwal'])->name('pilih_jadwal');
Route::post('/pilih-kursi', [BookingController::class, 'pilihKursi'])->name('pilih_kursi');
//Route::post('/konfirmasi-pemesanan', [BookingController::class, 'konfirmasiPemesanan'])->name('konfirmasi_pemesanan');

Route::get('/pemesanan', [BookingController::class, 'index'])->name('pemesanan');
Route::get('/pemesanan/search', [BookingController::class, 'search'])->name('search');

Route::get('/data-pemesan', [BookingController::class, 'dataPemesan'])->name('data_pemesan');
Route::post('/save-pemesan', [BookingController::class, 'savePemesan'])->name('save_pemesan');
Route::get('/pilih_kursi/{booking_id}', [BookingController::class, 'pilihKursi'])->name('pilih_kursi');


Route::get('/pilih_kursi', [BookingController::class, 'showSeatSelection']);
Route::post('/pilih_kursi', [BookingController::class, 'storeSeatSelection'])->name('store_seat_selection');

Route::post('/create-snap-token', [PaymentController::class, 'createSnapToken'])->name('create-snap-token');
//Route::get('/pembayaran/{booking_id}', [PaymentController::class, 'showPaymentPage'])->name('pembayaran');
Route::get('/pembayaran/{booking_id}', [PaymentController::class, 'createSnapToken'])->name('pembayaran');
Route::post('/midtrans/notification', [PaymentController::class, 'notificationHandler']);



//Route::get('/pembayaran', [PaymentController::class, 'showPaymentPage'])->name('pembayaran');
//Route::post('/pembayaran', [PaymentController::class, 'processPayment'])->name('process_payment');
//Route::post('/midtrans-notification', [PaymentController::class, 'notificationHandler'])->name('notification_handler');

//Route::post('/create-snap-token', [PaymentController::class, 'createSnapToken'])->name('create-snap-token');
//Route::post('/midtrans/notification', [PaymentController::class, 'handleNotification'])->name('midtrans.notification');
