<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Absent;
use App\Models\Employee;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function read(){

        $users = User::count();
        $employees = Employee::count();
        $absents = Absent::count();

        $weeklyAbsents = Absent::with('employee')->whereBetween('date',[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
        $monthlyAbsent = Absent::with('employee')->whereMonth('date', Carbon::now()->month)->get();

        $year = Carbon::now()->year;
        return Absent::with('employee')->where('date', $year)->whereMonth('date', '=', 1)->get();
        // return  Carbon::now()->format('Y');

        return response()->json([
            'users' => $users,
            'employees' => $employees,
            'absents' => $absents,
        ]);
    }
}
