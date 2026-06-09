<?php

namespace App\Http\Controllers;

use App\Exports\CashflowExport;
use App\Models\Cashflow;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class CashflowController extends Controller
{
    public function index(Request $request)
    {
        $user  = Auth::user();
        $date  = $request->get('date', now()->toDateString());

        $query = Cashflow::with('user')->whereDate('date', $date);

        // Isolate: cashiers only see their own booth entries
        if (!$user->isAdmin()) {
            $query->where('user_id', $user->id);
        }

        $cashflows = $query->orderBy('created_at','desc')->get();

        $totalIn   = $cashflows->where('type','in')->sum('amount');
        $totalOut  = $cashflows->where('type','out')->sum('amount');
        $balance   = $totalIn - $totalOut;

        return view('admin.kas', compact('cashflows','date','totalIn','totalOut','balance','user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date'        => 'required|date',
            'type'        => 'required|in:in,out',
            'description' => 'required|string|max:255',
            'amount'      => 'required|integer|min:1',
        ]);

        $user = Auth::user();

        $cashflow = Cashflow::create([
            'date'        => $request->date,
            'type'        => $request->type,
            'description' => $request->description,
            'amount'      => $request->amount,
            'user_id'     => $user->id,
            'booth_type'  => $user->assigned_booth ?? 'admin',
        ]);

        // Return print data via JSON for thermal receipt
        if ($request->expectsJson()) {
            return response()->json([
                'success'    => true,
                'print_data' => [
                    'type'        => $cashflow->type === 'in' ? 'PEMASUKAN' : 'PENGELUARAN',
                    'date'        => \Carbon\Carbon::parse($cashflow->date)->format('d/m/Y'),
                    'amount'      => $cashflow->amount,
                    'description' => $cashflow->description,
                    'cashier'     => $user->name,
                    'saved_at'    => now()->setTimezone('Asia/Jakarta')->format('d/m/Y H:i:s'),
                ],
                'message' => 'Catatan kas berhasil disimpan!',
            ]);
        }

        return back()->with('success', 'Catatan kas berhasil disimpan!');
    }

    public function export(Request $request)
    {
        $user        = Auth::user();
        $date        = $request->get('date', now()->toDateString());
        $boothFilter = $user->isAdmin() ? null : $user->id; // filter by user_id for cashiers
        $filename = 'buku-kas-'.$date.'.xlsx';

        return Excel::download(new CashflowExport($date, $user), $filename);
    }
}