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

class ReservationsExport implements FromCollection, WithHeadings, WithStyles, WithEvents 
{
    public function collection()
    {
        return Reservation::with(['driverInformation', 'payment', 'motorcycle'])->get()->map(function ($reservation) {
            $startDate = Carbon::parse($reservation->rental_start_date);
            $endDate = Carbon::parse($reservation->rental_end_date);
            $createdAt = Carbon::parse($reservation->created_at);
            
            $duration = $startDate->diffInDays($endDate);
            $durationText = $duration === 1 ? '1 day' : $duration . ' days';

            return [
                'Booking Date' => $createdAt->format('F j, Y, h:i A'),
                'Motorcycle Name' => $reservation->motorcycle->name, 
                'Plate Number' => $reservation->motorcycle->plate_number, 
                'Booking Reference' => $reservation->reference_id,
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
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Booking Date',
            'Booked Motorcycle',
            'Plate Number',
            'Booking Reference',
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
        ];
    }



    public function styles(Worksheet $sheet)
    {
        return [
            // Styling the header row
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                    'color' => ['rgb' => 'FFFFFF'], // White text
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4472C4'], // Dark blue header background
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Set width based on content and add borders
                foreach (range('A', 'S') as $columnID) {
                    // Auto-size column width
                    $sheet->getColumnDimension($columnID)->setAutoSize(true);

                    // Add borders to all cells
                    $sheet->getStyle($columnID . '1:' . $columnID . ($sheet->getHighestRow()))
                          ->getBorders()
                          ->getAllBorders()
                          ->setBorderStyle(Border::BORDER_THIN);
                }

                // Add some additional styling to data rows
                $highestRow = $sheet->getHighestRow();
                $sheet->getStyle('A2:S' . $highestRow)
                      ->getAlignment()
                      ->setVertical(Alignment::VERTICAL_CENTER)
                      ->setHorizontal(Alignment::HORIZONTAL_LEFT);

                // Alternating row colors for readability
                for ($row = 2; $row <= $highestRow; $row += 2) {
                    $sheet->getStyle('A' . $row . ':S' . $row)
                          ->getFill()
                          ->setFillType(Fill::FILL_SOLID)
                          ->getStartColor()
                          ->setRGB('F0F0F0'); // Light gray for alternate rows
                }
            },
        ];
    }
}