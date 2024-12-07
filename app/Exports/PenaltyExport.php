<?php

namespace App\Exports;

use App\Models\Penalty;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PenaltyExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{
    use Exportable;

    private $columnWidths = [
        'A' => 0,
        'B' => 0,
        'C' => 0,
        'D' => 0,
        'E' => 0,
        'F' => 0,
        'G' => 0, 
    ];

    public function collection()
    {
        $penalties = Penalty::with(['reservation', 'customer', 'driver'])
            ->get()
            ->map(function ($penalty, $index) {
                return [
                    'No.' => $index + 1, 
                'Date and Time' => $penalty->created_at->setTimezone('Asia/Manila')->format('F j, Y, g:ia'),

                    'Driver Name' => $penalty->driver->first_name . ' ' . $penalty->driver->last_name,
                    'Penalty Type' => $penalty->penalty_type,
                    'Description' => $penalty->description,
                    'Additional Payment' => '₱' . number_format($penalty->additional_payment, 2), 
                    'Status' => $penalty->status,
                ];
            });

        $this->updateColumnWidth('A', 'No.');
        $this->updateColumnWidth('B', 'Date and Time');
        $this->updateColumnWidth('C', 'Driver Name');
        $this->updateColumnWidth('D', 'Penalty Type');
        $this->updateColumnWidth('E', 'Description');
        $this->updateColumnWidth('F', 'Additional Payment');
        $this->updateColumnWidth('G', 'Status');

        foreach ($penalties as $penalty) {
            $this->updateColumnWidth('A', $penalty['No.']);
            $this->updateColumnWidth('B', $penalty['Date and Time']);
            $this->updateColumnWidth('C', $penalty['Driver Name']);
            $this->updateColumnWidth('D', $penalty['Penalty Type']);
            $this->updateColumnWidth('E', $penalty['Description']);
            $this->updateColumnWidth('F', $penalty['Additional Payment']);
            $this->updateColumnWidth('G', $penalty['Status']);
        }

        return $penalties;
    }

    public function headings(): array
    {
        return [
            'No.',
            'Date and Time',
            'Driver Name',
            'Penalty Type',
            'Description',
            'Additional Payment',
            'Status',
        ];
    }

    public function styles(Worksheet $sheet)
    {
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

    public function columnWidths(): array
    {
        return $this->columnWidths;
    }

    private function updateColumnWidth($column, $value)
    {
        $length = strlen($value);
        $this->columnWidths[$column] = max($this->columnWidths[$column], $length + 5); 
    }
}
