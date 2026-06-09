<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RekapanExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles
{
    protected string $date;
    protected ?string $boothFilter;
    protected int $rowIndex = 0;

    public function __construct(string $date, ?string $boothFilter = null)
    {
        $this->date        = $date;
        $this->boothFilter = $boothFilter;
    }

    public function collection()
    {
        $query = Transaction::with('user')->whereDate('transaction_date', $this->date)->orderBy('created_at');
        if ($this->boothFilter) {
            $query->where('booth_type', $this->boothFilter);
        }
        return $query->get();
    }

    public function headings(): array
    {
        return ['No','No. Transaksi','Waktu','Kasir','Loket','Mode Harga','Dewasa','Anak','Terusan','Total Pengunjung','Total Harga','Metode Bayar','Uang Diterima','Kembalian'];
    }

    public function map($t): array
    {
        $this->rowIndex++;
        return [
            $this->rowIndex,
            $t->transaction_number,
            $t->created_at->setTimezone('Asia/Jakarta')->format('H:i:s'),
            $t->user->name,
            $t->booth_label,
            strtoupper($t->pricing_mode ?? 'normal'),
            $t->adult_qty, $t->child_qty, $t->terusan_qty,
            $t->adult_qty + $t->child_qty + $t->terusan_qty,
            $t->total_price,
            strtoupper($t->payment_method),
            $t->cash_received, $t->cash_change,
        ];
    }

    public function title(): string { return 'Rekapan '.$this->date; }
    public function styles(Worksheet $sheet) { return [1 => ['font' => ['bold' => true]]]; }
}