<?php
namespace App\Exports;

use App\Models\Reservation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Carbon\Carbon;

class CancelledBookingsExport implements FromCollection, WithHeadings, WithStyles, WithEvents 
{
    public function collection()
    {
        return Reservation::with(['driverInformation', 'payment', 'motorcycle'])
            ->whereIn('status', ['Completed']) 
            ->get()
            ->map(function ($reservation) {
                $startDate = Carbon::parse($reservation->rental_start_date);
                $endDate = Carbon::parse($reservation->rental_end_date);
                $createdAt = Carbon::parse($reservation->created_at);
                
                $duration = $startDate->diffInDays($endDate);
                $durationText = $duration === 1 ? '1 day' : $duration . ' days';
    
                return [
                    'Booking Date' => $createdAt->format('F j, Y, h:i A'),
                    'Booking Status' => ucfirst($reservation->status),
                    'Booking Reference' => $reservation->reference_id,
                    'Motorcycle Name' => $reservation->motorcycle->name, 
                    'Plate Number' => $reservation->motorcycle->plate_number, 
                    'Driver Name' => $reservation->driverInformation->first_name . ' ' . $reservation->driverInformation->last_name,
                    'Email' => $reservation->driverInformation->email,
                    'Address' => $reservation->driverInformation->address,
                    'Birthdate' => $startDate->format('F j, Y'), 
                    'Contact Number' => $reservation->driverInformation->contact_number,
                    'Gender' => ucfirst($reservation->driverInformation->gender), 
                    'Rental Start Date' => $startDate->format('F j, Y'), 
                    'Pick Up' => $startDate->format('h:i A'),
                    'Rental End Date' => $endDate->format('F j, Y'), 
                    'Drop Off' => $endDate->format('h:i A'), 
                    'Duration' => $durationText, 
                    'Payment Method' => ucfirst($reservation->payment_method ?? 'N/A'),
                    'GCash Number' => $reservation->payment->number ?? 'N/A', 
                    'GCash Receipt' => $reservation->payment->receipt ?? 'N/A',
                    'Total Amount' => '₱' . number_format($reservation->total, 2),
                    'Payment Status' => ucfirst($reservation->payment->status ?? 'Pending'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Booking Date',
            'Booking Status',
            'Booking Reference',
            'Booked Motorcycle',
            'Plate Number',
            'Driver Name',
            'Email',
            'Address',
            'Birthdate',
            'Contact Number',
            'Gender',
            'Rental Start Date',
            'Pick Up',
            'Rental End Date',
            'Drop Off',
            'Duration',
            'Payment Method',
            'GCash Number',
            'GCash Receipt',
            'Total Amount',
            'Payment Status',
           
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
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4472C4'],
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                foreach (range('A', 'U') as $columnID) {
                    $sheet->getColumnDimension($columnID)->setAutoSize(true);
                    $sheet->getStyle($columnID . '1:' . $columnID . ($sheet->getHighestRow()))
                          ->getBorders()
                          ->getAllBorders()
                          ->setBorderStyle(Border::BORDER_THIN);
                }

                $highestRow = $sheet->getHighestRow();
                $sheet->getStyle('A2:U' . $highestRow)
                      ->getAlignment()
                      ->setVertical(Alignment::VERTICAL_CENTER)
                      ->setHorizontal(Alignment::HORIZONTAL_LEFT);

                for ($row = 2; $row <= $highestRow; $row += 2) {
                    $sheet->getStyle('A' . $row . ':U' . $row)
                          ->getFill()
                          ->setFillType(Fill::FILL_SOLID)
                          ->getStartColor()
                          ->setRGB('F0F0F0'); 
                }
            },
        ];
    }
}