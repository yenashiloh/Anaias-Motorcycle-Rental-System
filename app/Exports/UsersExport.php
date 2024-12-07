<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\Exportable;

class UsersExport implements FromCollection, WithHeadings, WithStyles, WithColumnFormatting
{
    use Exportable;

    public function collection()
    {
        return Customer::all()->map(function ($customer, $index) {
            return [
                'No.' => $index + 1, 
                'Date Created' => $customer->created_at->timezone('Asia/Manila')->format('F j, Y, g:ia'), 
                'Email' => $customer->email,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No.', 
            'Date Created',
            'Email',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        foreach (range('A', 'C') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true); 
        }

        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4472C4'],
                ],
            ],
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DATETIME, // Format Date
        ];
    }
}
