<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use App\Models\Motorcycle;
use App\Models\Reservation;
use App\Models\DriverInformation;

class AdminDashboardController extends Controller
{
    //show dashboard
    public function showAdminDashboard()
    {
        $admin = Auth::guard('admin')->user(); 
        $customerCount = Customer::count(); 
        $motorcycleCount = Motorcycle::count();
        $reservationCount = Reservation::count();
        $availableMotorcycleCount = Motorcycle::where('status', 'Available')->count();
        $notAvailableMotorcycleCount = Motorcycle::where('status', 'Not Available')->count();
        $maintenanceMotorcycleCount = Motorcycle::where('status', 'Maintenance')->count();

        // gender counts
        $genderCounts = DriverInformation::select('gender', \DB::raw('count(*) as count'))
            ->groupBy('gender')
            ->pluck('count', 'gender')
            ->toArray();

        $genderCounts = array_merge(['male' => 0, 'female' => 0], $genderCounts);

        // motorcycle reservation counts
        $motorcycleReservations = Reservation::select('motor_id', \DB::raw('count(*) as count'))
            ->groupBy('motor_id')
            ->pluck('count', 'motor_id')
            ->toArray();

        // motorcycle names for labels
        $motorcycleNames = Motorcycle::whereIn('motor_id', array_keys($motorcycleReservations))
            ->pluck('name', 'motor_id')
            ->toArray();

        //age counts
        $ageData = DriverInformation::select(\DB::raw('FLOOR(DATEDIFF(CURDATE(), birthdate) / 365.25) as age'), \DB::raw('count(*) as count'))
        ->groupBy('age')
        ->orderBy('age')
        ->get();

    $ageCounts = [];
    foreach ($ageData as $data) {
        $ageCounts[$data->age] = $data->count;
    }

        return view('admin.admin-dashboard', compact(
            'admin', 
            'customerCount', 
            'motorcycleCount', 
            'availableMotorcycleCount',
            'reservationCount',
            'genderCounts',
            'motorcycleReservations',
            'motorcycleNames', 
            'notAvailableMotorcycleCount',
            'ageCounts',
            'maintenanceMotorcycleCount'
        ));
    }

    
    

}
