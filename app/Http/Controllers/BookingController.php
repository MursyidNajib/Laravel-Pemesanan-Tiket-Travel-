<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Route;
use App\Models\Bus;
use App\Models\Schedule;
use App\Models\Booking;
use App\Models\Passenger;
use App\Models\Seat;

class BookingController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function search(Request $request)
    {
        $departure = $request->input('departure');
        $destination = $request->input('destination');
        $date = $request->input('date');
        $total_passengers = $request->input('passenger');

        $schedules = Schedule::whereHas('route', function($query) use ($departure, $destination) {
            $query->where('departure', $departure)
                ->where('destination', $destination);
        })
        ->where('departure_date', $date)
        ->where('available_seats', '>=', $total_passengers) // Tambahkan kondisi ini
        ->get();

        return view('pemesanan', ['schedules' => $schedules, 'total_passengers' => $total_passengers]);
    }


    public function savePemesan(Request $request)
    {
        // Validasi data
        $request->validate([
            'customer_name' => 'required',
            'customer_email' => 'required|email',
            'customer_address' => 'required',
            'customer_phone' => 'required',
            'passenger1' => 'required'
        ]);

        // Simpan data pemesan
        $booking = new Booking();
        $booking->customer_name = $request->customer_name;
        $booking->customer_email = $request->customer_email;
        $booking->customer_address = $request->customer_address;
        $booking->customer_phone = $request->customer_phone;
        $booking->schedule_id = $request->schedule_id;
        $booking->total_passengers = $request->input('total_passengers', 1);
        $booking->total_price = Schedule::find($request->schedule_id)->price * $booking->total_passengers;
        $booking->status = 'pending';
        $booking->save();

        // Simpan data penumpang
        for ($i = 1; $i <= $booking->total_passengers; $i++) {
            $passenger = new Passenger();
            $passenger->booking_id = $booking->id;
            $passenger->name = $request->input('passenger' . $i);
            $passenger->save();
        }

        // Redirect ke halaman pilih kursi dengan booking_id
        return redirect()->route('pilih_kursi', ['booking_id' => $booking->id]);
    }


    public function dataPemesan(Request $request)
    {
        $schedule_id = $request->schedule_id;
        $total_passengers = $request->input('total_passengers', 1); // Default to 1 if not provided
    
        return view("data_pemesan", ['schedule_id' => $schedule_id, 'total_passengers' => $total_passengers]);
    }

    public function showSeatSelection() {
        // Ambil data kursi dari database untuk ditampilkan
        $seats = Seat::all();
        return view('pilih_kursi', compact('seats'));
    }

    public function storeSeatSelection(Request $request) {
        // Simpan kursi yang dipilih ke database
        $selectedSeats = explode(',', $request->input('selectedSeats'));
        $booking_id = $request->input('booking_id');
    
        foreach ($selectedSeats as $seat_number) {
            Seat::where('schedule_id', Booking::find($booking_id)->schedule_id)
                ->where('seat_number', $seat_number)
                ->update(['status' => 'booked']);
        }
    
        // Kurangi jumlah kursi yang tersedia pada jadwal
        $schedule = Schedule::find(Booking::find($booking_id)->schedule_id);
        $schedule->available_seats -= count($selectedSeats);
        $schedule->save();
    
        return redirect()->route('pembayaran', ['booking_id' => $booking_id]);
    }
    
    

    public function pilihKursi(Request $request, $booking_id)
    {
        $booking = Booking::find($booking_id);
        $schedule_id = $booking->schedule_id;
        $total_passengers = $booking->total_passengers;

        $seats = Seat::where('schedule_id', $schedule_id)->get();

        return view('pilih_kursi', compact('booking', 'seats', 'total_passengers'));
    }


    public function showPilihJadwal() {
        return view('pemesanan');
    }

    public function konfirmasiPemesanan(Request $request)
    {
        $schedule_id = $request->schedule_id;
        $customer_name = $request->customer_name;
        $customer_email = $request->customer_email;
        $customer_address = $request->customer_address;
        $customer_phone = $request->customer_phone;
        $passenger_names = $request->passenger_names;
        $seat_numbers = $request->seat_numbers;

        $booking = Booking::create([
            'schedule_id' => $schedule_id,
            'customer_name' => $customer_name,
            'customer_email' => $customer_email,
            'customer_address' => $customer_address,
            'customer_phone' => $customer_phone,
            'total_passengers' => count($passenger_names),
            'total_price' => Schedule::find($schedule_id)->price * count($passenger_names),
            'status' => 'pending',
        ]);

        foreach ($passenger_names as $name) {
            Passenger::create([
                'booking_id' => $booking->id,
                'name' => $name,
            ]);
        }

        foreach ($seat_numbers as $seat_number) {
            Seat::where('schedule_id', $schedule_id)
                ->where('seat_number', $seat_number)
                ->update(['status' => 'booked']);
        }

        return redirect()->route('home')->with('success', 'Pemesanan berhasil, silakan lanjutkan ke pembayaran.');
    }
}
