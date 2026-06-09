<?php

namespace App\Http\Controllers;

use App\Models\NewsArticle;
use App\Services\HolidayService;
use Carbon\Carbon;
use Illuminate\Http\Request; // <-- KITA IMPORT INI BUAT NANGKAP PILIHAN USER

class PublicController extends Controller
{
    // ── WA admin number — update this to the real number ────────────
    const WA_NUMBER = '6285327100908';

    public function index()
    {
        $ticketInfo = [
            'weekday' => ['adult'=>5000,'child'=>2000,'terusan'=>12000],
            'weekend' => ['adult'=>7000,'child'=>3000,'terusan'=>12000],
            'lebaran' => ['adult'=>10000,'child'=>10000,'terusan'=>0],
            'flat'    => 5000,
        ];

        // ── KITA SEJajarkan VARIABELNYA DAN URUTKAN PAKAI TANGGAL BARU ──
        $news = NewsArticle::where('is_published', true)
            ->orderBy('published_date', 'desc') // Mengurutkan berdasarkan tanggal event pilihan Tejo
            ->take(6)
            ->get();

        $waNumber = self::WA_NUMBER;

        // Di bagian compact, ganti 'newsArticles' menjadi 'news'
        return view('public.landing', compact('ticketInfo', 'news', 'waNumber'));
    }

    // ── FUNGSI BOOKING YANG SUDAH KITA KALIBRASI SECARA DINAMIS ──
    public function booking(Request $request)
    {
        // 1. Tangkap pilihan mode hari kerja atau akhir pekan (default ke weekday)
        $mode = $request->query('mode', 'weekday');

        // 2. Tarik harga dinamis dari HolidayService bawaan lo
        $prices = [
            'weekday' => HolidayService::getLoketMasukPrices(Carbon::today()->startOfWeek()),
            'weekend' => HolidayService::getLoketMasukPrices(Carbon::today()->startOfWeek()->addDays(5)),
        ];

        // 3. Ambil paket spesifik dan label teksnya berdasarkan mode tombol yang diklik user
        if ($mode === 'weekend') {
            $selectedPrices = $prices['weekend'];
            $modeLabel = '🌟 Weekend / Hari Libur';
        } else {
            $selectedPrices = $prices['weekday'];
            $modeLabel = '📅 Hari Kerja';
        }

        $holidayDates  = HolidayService::getHolidayDatesJson();
        $lebaranDates  = HolidayService::getLebaranDatesJson();
        $waNumber      = self::WA_NUMBER;

        // 4. Oper semua data sakti ini ke blade booking publik
        return view('public.booking', compact('selectedPrices', 'mode', 'modeLabel', 'holidayDates', 'lebaranDates', 'waNumber'));
    }
}