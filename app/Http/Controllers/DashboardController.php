<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Services\HolidayService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user      = Auth::user();
        $today     = Carbon::now('Asia/Jakarta');
        $isLebaran = ($user->assigned_booth === 'loket_masuk') && HolidayService::isLebaran($today);
        $isHoliday = HolidayService::isWeekendOrHoliday($today);
        $dayLabel  = HolidayService::getLabel($today);

        $prices = ($user->assigned_booth === 'loket_masuk')
            ? HolidayService::getLoketMasukPrices($today)
            : HolidayService::getFlatPrice();

        // Data isolation: cashiers only see their own booth stats
        $statsQuery = Transaction::whereDate('transaction_date', $today->toDateString());
        if (!$user->isAdmin()) {
            $statsQuery->where('user_id', $user->id);
        }

        $todayStats = $statsQuery
            ->selectRaw('COUNT(*) as trx_count, SUM(total_price) as total_revenue, SUM(adult_qty+child_qty+terusan_qty) as total_visitors')
            ->first();

        return view('admin.dashboard', compact(
            'user','today','isLebaran','isHoliday','dayLabel','prices','todayStats'
        ));
    }

    public function storeTicket(Request $request)
    {
        $request->validate([
            'booth_type'     => 'required|in:loket_masuk,kolam_renang,kelinci',
            'adult_qty'      => 'required|integer|min:0',
            'child_qty'      => 'required|integer|min:0',
            'terusan_qty'    => 'required|integer|min:0',
            'total_price'    => 'required|integer|min:0',
            'payment_method' => 'required|in:cash,qris',
            'cash_received'  => 'nullable|integer|min:0',
            'cash_change'    => 'nullable|integer',
            'pricing_mode'   => 'nullable|in:normal,lebaran',
        ]);

        if (($request->adult_qty + $request->child_qty + $request->terusan_qty) < 1) {
            return response()->json(['success'=>false,'message'=>'Jumlah tiket minimal 1.'], 422);
        }

        // Kita buat object kosongan baru dulu untuk memutus hubungan magic binding
        $savedTrx = new Transaction();
        
        $savedTrx->transaction_number = Transaction::generateNumber();
        $savedTrx->user_id = (int) auth()->user()->id; // Mengambil property ID murni dari object user yang login
        $savedTrx->booth_type         = $request->booth_type;
        $savedTrx->pricing_mode       = $request->pricing_mode ?? 'normal';
        $savedTrx->adult_qty          = (int) $request->adult_qty;
        $savedTrx->child_qty          = (int) $request->child_qty;
        $savedTrx->terusan_qty        = (int) $request->terusan_qty;
        $savedTrx->total_price        = (int) $request->total_price;
        $savedTrx->payment_method     = $request->payment_method;
        $savedTrx->cash_received      = (int) ($request->cash_received ?? 0);
        $savedTrx->cash_change        = (int) ($request->cash_change ?? 0);
        $savedTrx->transaction_date   = now()->toDateString();
        
        // Simpan menggunakan instansiasi objek murni
        $savedTrx->save(); 

        return response()->json([
            'success'    => true,
            'print_data' => $this->buildPrintData($savedTrx), // Ganti variabelnya jadi $savedTrx di sini juga
        ]);
    }

    protected function buildPrintData(Transaction $t): array
    {
        $date   = Carbon::parse($t->transaction_date);
        $prices = ($t->booth_type === 'loket_masuk')
            ? HolidayService::getLoketMasukPrices($date)
            : HolidayService::getFlatPrice();

        // If lebaran was active, use lebaran prices for receipt line items
        if ($t->pricing_mode === 'lebaran') {
            $prices = ['adult'=>10000,'child'=>10000,'terusan'=>0,'mode'=>'lebaran'];
        }

        return [
            'no'            => $t->transaction_number,
            'booth'         => $t->booth_label,
            'cashier'       => $t->user->name,
            'date'          => $t->created_at->setTimezone('Asia/Jakarta')->format('d/m/Y H:i'),
            'adult_qty'     => $t->adult_qty,
            'child_qty'     => $t->child_qty,
            'terusan_qty'   => $t->terusan_qty,
            'adult_price'   => $prices['adult'],
            'child_price'   => $prices['child'],
            'terusan_price' => $prices['terusan'] ?? 0,
            'total_price'   => $t->total_price,
            'payment_method'=> strtoupper($t->payment_method),
            'cash_received' => $t->cash_received,
            'cash_change'   => $t->cash_change,
            'pricing_mode'  => $t->pricing_mode,
        ];
    }
}