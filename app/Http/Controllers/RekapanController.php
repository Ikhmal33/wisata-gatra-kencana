<?php

namespace App\Http\Controllers;

use App\Exports\RekapanExport;
use App\Exports\RekapanBulananExport;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class RekapanController extends Controller
{
    public function index(Request $request)
    {
        $user   = Auth::user();
        $date   = $request->get('date', now()->toDateString());

        $query = Transaction::with('user')->whereDate('transaction_date', $date);

        // Data isolation: non-admin users only see their own booth
        if (!$user->isAdmin()) {
            $query->where('booth_type', $user->assigned_booth);
        }

        $transactions = $query->orderBy('created_at','desc')->get();

        $totalVisitors = $transactions->sum(fn($t) => $t->adult_qty + $t->child_qty + $t->terusan_qty);
        $totalRevenue  = $transactions->sum('total_price');

        $boothBreakdown   = $transactions->groupBy('booth_type')->map(fn($g) => [
            'count'    => $g->count(),
            'visitors' => $g->sum(fn($t) => $t->adult_qty + $t->child_qty + $t->terusan_qty),
            'revenue'  => $g->sum('total_price'),
        ]);

        $paymentBreakdown = $transactions->groupBy('payment_method')->map(fn($g) => [
            'count'   => $g->count(),
            'revenue' => $g->sum('total_price'),
        ]);

        return view('admin.rekapan', compact(
            'transactions','date','totalVisitors','totalRevenue',
            'boothBreakdown','paymentBreakdown','user'
        ));
    }

    public function export(Request $request)
    {
        $user = Auth::user();
        $date = $request->get('date', now()->toDateString());

        // Role-isolated export booth filter
        $boothFilter = $user->isAdmin() ? null : $user->assigned_booth;
        $filename = 'rekapan-'.$date.($boothFilter ? '-'.$boothFilter : '').'.xlsx';

        return Excel::download(new RekapanExport($date, $boothFilter), $filename);
    }

    // ── Monthly recap (admin only) ──────────────────────────────
    public function monthly(Request $request)
    {
        $user  = Auth::user();
        if (!$user->isAdmin()) abort(403);

        $month = $request->get('month', now()->format('Y-m'));
        [$year, $mon] = explode('-', $month);

        $transactions = Transaction::with('user')
            ->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $mon)
            ->orderBy('transaction_date')
            ->get();

        // Daily aggregates
        $dailyStats = $transactions
            ->groupBy(fn($t) => $t->transaction_date->format('Y-m-d'))
            ->map(fn($g) => [
                'date'     => $g->first()->transaction_date->format('d M'),
                'visitors' => $g->sum(fn($t) => $t->adult_qty + $t->child_qty + $t->terusan_qty),
                'revenue'  => $g->sum('total_price'),
                'trx'      => $g->count(),
            ])->values();

        $grandTotal    = $transactions->sum('total_price');
        $totalVisitors = $transactions->sum(fn($t) => $t->adult_qty + $t->child_qty + $t->terusan_qty);

        $boothBreakdown = $transactions->groupBy('booth_type')->map(fn($g) => [
            'visitors' => $g->sum(fn($t) => $t->adult_qty + $t->child_qty + $t->terusan_qty),
            'revenue'  => $g->sum('total_price'),
        ]);

        return view('admin.rekapan_bulanan', compact(
            'month','dailyStats','grandTotal','totalVisitors','boothBreakdown','user'
        ));
    }

    public function exportMonthly(Request $request)
    {
        if (!Auth::user()->isAdmin()) abort(403);

        $month    = $request->get('month', now()->format('Y-m'));
        $filename = 'rekapan-bulanan-'.$month.'.xlsx';

        return Excel::download(new RekapanBulananExport($month), $filename);
    }
}