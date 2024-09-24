<?php

namespace App\Http\Controllers;

use App\Models\Motorcycle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Customer;

class HomeController extends Controller
{
    public function home()
    {
        $motorcycles = Motorcycle::all();
        $isCustomerLoggedIn = Auth::guard('customer')->check();
    
        return view('welcome', compact('motorcycles', 'isCustomerLoggedIn'));
    }

   public function viewMotorcycleCategories()
   {
       $motorcycles = Motorcycle::all();
       $isCustomerLoggedIn = Auth::guard('customer')->check();

       return view('motorcycles', compact('motorcycles', 'isCustomerLoggedIn'));
   }

   public function viewDetailsMotorcycle($id)
   {
       $motorcycle = Motorcycle::findOrFail($id);
       $isCustomerLoggedIn = Auth::guard('customer')->check();
   
       return view('motorcycle.details-motorcycle', compact('motorcycle', 'isCustomerLoggedIn'));
   }
   
   
}
