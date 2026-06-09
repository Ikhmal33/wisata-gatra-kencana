<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RekapanBulananExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles
{
    protected string $month;
    protected int $rowIndex = 0;

    public function __construct(string $month) { $this->month = $month; }

    public function collection()
    {
        [$y,$m] = explode('-', $this->month);
        return Transaction::with('user')
            ->whereYear('transaction_date',$y)->whereMonth('transaction_date',$m)
            ->orderBy('transaction_date')->orderBy('created_at')
            ->get();
    }

    public function headings(): array
    {
        return ['No','Tanggal','No. Transaksi','Kasir','Loket','Mode','Dewasa','Anak','Terusan','Total Tamu','Total Harga','Metode'];
    }

    public function map($t): array
    {
        $this->rowIndex++;
        return [
            $this->rowIndex,
            $t->transaction_date->format('d/m/Y'),
            $t->transaction_number,
            $t->user->name,
            $t->booth_label,
            strtoupper($t->pricing_mode ?? 'normal'),
            $t->adult_qty, $t->child_qty, $t->terusan_qty,
            $t->adult_qty + $t->child_qty + $t->terusan_qty,
            $t->total_price,
            strtoupper($t->payment_method),
        ];
    }

    public function title(): string { return 'Bulanan '.$this->month; }
    public function styles(Worksheet $sheet) { return [1 => ['font' => ['bold' => true]]]; }
}