<?php

namespace App\Exports;

use App\Models\Cashflow;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CashflowExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles
{
    protected string $date;
    protected User $user;
    protected int $rowIndex = 0;

    public function __construct(string $date, User $user)
    {
        $this->date = $date;
        $this->user = $user;
    }

    public function collection()
    {
        $query = Cashflow::with('user')->whereDate('date', $this->date)->orderBy('created_at');
        if (!$this->user->isAdmin()) {
            $query->where('user_id', $this->user->id);
        }
        return $query->get();
    }

    public function headings(): array
    {
        return ['No','Tanggal','Waktu','Jenis','Keterangan','Nominal (Rp)','Kasir','Loket'];
    }

    public function map($cf): array
    {
        $this->rowIndex++;
        return [
            $this->rowIndex,
            $cf->date->format('d/m/Y'),
            $cf->created_at->setTimezone('Asia/Jakarta')->format('H:i:s'),
            $cf->type === 'in' ? 'PEMASUKAN' : 'PENGELUARAN',
            $cf->description,
            $cf->amount,
            $cf->user->name ?? '-',
            $cf->booth_type ?? '-',
        ];
    }

    public function title(): string { return 'Kas '.$this->date; }
    public function styles(Worksheet $sheet) { return [1 => ['font' => ['bold' => true]]]; }
}