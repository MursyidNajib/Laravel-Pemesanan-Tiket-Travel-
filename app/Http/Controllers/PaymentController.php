<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = 'SB-Mid-server-UlHHotU-lFGirVMb2lfpXW9I';
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;
    }

    public function createSnapToken(Request $request)
    {
        $booking = Booking::find($request->booking_id);
        $params = [
            'transaction_details' => [
                'order_id' => $booking->id,
                'gross_amount' => $booking->total_price,
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mendapatkan token pembayaran.');
        }
    
        return view('pembayaran', compact('booking', 'snapToken'));
    }

    public function notificationHandler(Request $request)
    {
        Log::info('Midtrans notification received:', $request->all());
        
        // Buat instance notifikasi
        $notification = new Notification();

        // Ambil notifikasi status dan order_id dari Midtrans
        $transactionStatus = $notification->transaction_status;
        $orderId = $notification->order_id;

        Log::info('Transaction status:', ['status' => $transactionStatus]);
        Log::info('Order ID:', ['order_id' => $orderId]);

        // Cari booking yang sesuai dengan order_id
        $booking = Booking::findOrFail($orderId);

        // Update status booking berdasarkan notifikasi Midtrans
        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            $booking->status = 'paid';
        } elseif ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
            $booking->status = 'cancelled';
        }

        // Simpan perubahan status ke database
        $booking->save();

        Log::info('Booking updated:', ['booking_id' => $booking->id, 'status' => $booking->status]);

        return response()->json(['status' => 'success']);
    }
}
