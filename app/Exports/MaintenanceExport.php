<?php

namespace App\Exports;

use App\Models\Motorcycle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\Exportable;

class MaintenanceExport implements FromCollection, WithHeadings, WithStyles
{
    use Exportable;

    public function collection()
    {
        return Motorcycle::where('status', 'Maintenance') 
            ->get()
            ->map(function ($motorcycle, $index) {
                return [
                    'No.' => $index + 1, 
                    'Name' => $motorcycle->name,
                    'Brand' => $motorcycle->brand,
                    'Model' => $motorcycle->model,
                    'Year' => $motorcycle->year,
                    'Color' => $motorcycle->color,
                    'Body Number' => $motorcycle->body_number ?? 'N/A', 
                    'Plate Number' => $motorcycle->plate_number ?? 'N/A', 
                    'Price' => '₱' . number_format($motorcycle->price, 2),
                    'Status' => $motorcycle->status, 
                ];
            });
    }

    public function headings(): array
    {
        return [
            'No.',
            'Name',
            'Brand',
            'Model',
            'Year',
            'Color',
            'Body Number',
            'Plate Number',
            'Price',
            'Maintenance Status',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        foreach (range('A', 'J') as $column) {
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
}
