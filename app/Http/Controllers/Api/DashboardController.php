<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Absent;
use App\Models\Employee;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function read()
    {

        // return Absent::with('employee')->select(['employee:name'])->orderBy('id')->get()->groupBy('employee_id');
        // return DB::table('employees')
        // ->join('absents', 'users.id', '=' ,'admin_notifications.from_user_id')
        // ->select('users.name')
        // ->where('admin_notifications.from_user_id', '=',  $item->from_user_id)
        // ->get();

        // return DB::table('absents')
        //     ->join('employees', 'employees.id', '=', 'absents.employee_id')
        //     ->select('employees.name')
        //     ->groupBy('employees.name')
        //     ->get();

        $empSenior = array();
        $empJunior = array();
        $employess = Employee::all();
        foreach($employess as $data){
            if(Str::contains($data->position, ['Senior'])){
               $empSenior[] = Employee::where('position', $data->position, ['Senior'])->count();
            }

            if(Str::contains($data->position, ['Junior'])){
                $empJunior[] = Employee::where('position', $data->position, ['Junior'])->count();
            }
        }

        $now = Carbon::now();
        $year = Carbon::now()->year;

        $weekStartDate = $now->startOfWeek()->format('Y-m-d');
        $weekEndDate = $now->endOfWeek()->format('Y-m-d');

        $userCount = User::count();
        $userRoleAdmin = User::where('role_id', 1)->count();
        $userRoleUser = User::where('role_id', 2)->count();

        $employeesCount = Employee::count();

        $absentsCount = Absent::count();
        $weeklyAbsents = Absent::with('employee')->where('date', '>=' ,$weekStartDate)->where('date', '<=', $weekEndDate)->get();
        $weeklyAbsentsCount = Absent::where('date', '>=' ,$weekStartDate)->where('date', '<=', $weekEndDate)->count();
        $monthlyAbsent = Absent::with('employee')->whereMonth('date', Carbon::now()->month)->get();
        $monthlyAbsentCount = Absent::with('employee')->whereMonth('date', Carbon::now()->month)->count();
        $yearAbsents = Absent::with('employee')->where('date', $year)->get();
        $yearAbsentCount = Absent::where('date', $year)->count();

        // $monthNum = 12;
        // $AbMonthlyOfYear = array();
        // for($monthNum = 1;$monthNum<=12;$monthNum++){
        //     $AbMonthlyOfYear[] = Absent::with('employee')->where('date', $year)->whereMonth('date', '=', $monthNum)->count();
        // }

        return response()->json([
            'user' => [
                'allUser' => $userCount,
                'admin' => $userRoleAdmin,
                'user' => $userRoleUser,
            ],
            'employee' => [
                'allEmployee' =>  $employeesCount,
                'senior' => count($empSenior),
                'junior' => count($empJunior),
            ],
            'absent' => [
                'absentCount' => $absentsCount,
                'absentWeekCount' => $weeklyAbsentsCount,
                'absentMonthCount' => $monthlyAbsentCount,
                'absentYearCount' => $yearAbsentCount,
                'weeklyAbsents' => $weeklyAbsents,
                'monthlyAbsents' => $monthlyAbsent,
                'yearAbsents' => $yearAbsents,
                'yearAbsentCount' => $yearAbsentCount,
            ],
        ]);
    }
}
