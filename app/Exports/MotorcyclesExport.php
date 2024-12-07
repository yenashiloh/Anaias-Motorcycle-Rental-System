<?php

namespace App\Exports;

use App\Models\Motorcycle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\Exportable;

class MotorcyclesExport implements FromCollection, WithHeadings, WithStyles
{
    use Exportable;

    public function collection()
    {
        return Motorcycle::whereIn('status', ['Available', 'Not Available']) 
            ->get()
            ->map(function ($motorcycle, $index) {
                return [
                    'No.' => $index + 1, 
                    'Name' => $motorcycle->name,
                    'Brand' => $motorcycle->brand,
                    'Model' => $motorcycle->model,
                    'Year' => $motorcycle->year,
                    'Color' => $motorcycle->color,
                    'Plate Number' => $motorcycle->plate_number,
                    'Price' => '₱' . number_format($motorcycle->price, 2),
                    'Description' => strip_tags($motorcycle->description), 
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
            'Plate Number',
            'Price',
            'Description',
            'Status',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        foreach (range('A', 'I') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true); 
        }

        $sheet->getColumnDimension('I')->setWidth(30);

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
