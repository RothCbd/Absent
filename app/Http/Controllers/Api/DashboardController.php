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

        $userCount = User::where('id', '!=', auth('sanctum')->user()->id)->count();
        $userRoleAdmin = User::where('role_id', 1)->count();
        $userRoleUser = User::where('role_id', 2)->count();

        $employeesCount = Employee::count();

        $now = Carbon::now();
        $year = Carbon::now()->year;
        $weekStartDate = $now->startOfWeek()->format('Y-m-d');
        $weekEndDate = $now->endOfWeek()->format('Y-m-d');

        // ------ABSENTS-WEEKLY-----
        $absentWeeklyData = array();
        $weeklyAbsentsCount =  DB::table('absents')
            ->join('employees', 'employees.id', '=' ,'absents.employee_id')
            ->where('date', '>=' ,$weekStartDate)
            ->where('date', '<=', $weekEndDate)
            ->where('is_inactive', false)
            ->count();

        $absentWeeklys = Employee::whereHas('absent')->with('absent', function($q) use($weekStartDate, $weekEndDate){
            $q->where('date', '>=' ,$weekStartDate);
            $q->where('date', '<=', $weekEndDate);
            $q->orderBy('date', 'DESC')->get();
        })->where('is_inactive', false)->get();

        foreach($absentWeeklys as $absentWeekly){
            if(count($absentWeekly->absent) > 0){
                $absent_total = 0;
                foreach($absentWeekly->absent as $absent)
                {
                    $absent_total = $absent_total + $absent->number;
                }
                $absentWeeklyData[] = array(
                    'id' => $absentWeekly->id,
                    'name' => $absentWeekly->name,
                    'pic' => $absentWeekly->pic,
                    'profile_color' => $absentWeekly->profile_color,
                    'absent_count' => count($absentWeekly->absent),
                    'absent_total' => $absent_total,
                    'absents' => $absentWeekly->absent
                );
            }
        }

        // ------ABSENTS-MONTHLY-----
        $absentMonthlyData = array();
        $monthlyAbsentCount = DB::table('absents')
            ->join('employees', 'employees.id', '=' ,'absents.employee_id')
            ->whereMonth('date', Carbon::now()->month)
            ->where('is_inactive', false)
            ->count();

        $absentMonthlys = Employee::whereHas('absent')->with('absent', function($q){
            $q->whereMonth('date', Carbon::now()->month);
            $q->orderBy('date', 'DESC')->get();
        })->where('is_inactive', false)->get();

        foreach($absentMonthlys as $absentMonthly){
            if(count($absentMonthly->absent) > 0){
                $absent_total = 0;
                foreach($absentMonthly->absent as $absent)
                {
                    $absent_total = $absent_total + $absent->number;
                }
                $absentMonthlyData[] = array(
                    'id' => $absentMonthly->id,
                    'name' => $absentMonthly->name,
                    'pic' => $absentMonthly->pic,
                    'profile_color' => $absentMonthly->profile_color,
                    'absent_count' => count($absentMonthly->absent),
                    'absent_total' => $absent_total,
                    'absents' => $absentMonthly->absent
                );
            }
        }
        // return $absentMonthlyData;


        // ------ABSENTS-YEARLY-----
        $absentYearlyData = array();
        $yearAbsentCount = DB::table('absents')
            ->join('employees', 'employees.id', '=' ,'absents.employee_id')
            ->where('date', $year)
            ->where('is_inactive', false)
            ->count();

        $absentYearlys = Employee::whereHas('absent')->with('absent', function($q) use ($year){
            $q->where('date', $year);
        })->where('is_inactive', false)->get();

        foreach($absentYearlys as $absentYearly){
            if(count($absentYearly->absent) > 0){
                $absent_total = 0;
                foreach($absentYearly->absent as $absent)
                {
                    $absent_total = $absent_total + $absent->number;
                }
                $absentYearlyData[] = array(
                    'id' => $absentYearly->id,
                    'name' => $absentYearly->name,
                    'pic' => $absentYearly->pic,
                    'profile_color' => $absentYearly->profile_color,
                    'absent_count' => count($absentYearly->absent),
                    'absent_total' => $absent_total,
                    'absents' => $absentYearly->absent
                );
            }
        }

        $absentsCount = DB::table('absents')
            ->join('employees', 'employees.id', '=' ,'absents.employee_id')
            ->where('is_inactive', false)
            ->count();

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
                'weeklyAbsents' => $absentWeeklyData,
                'monthlyAbsents' => $absentMonthlyData,
                'yearAbsents' => $absentYearlyData,
                'yearAbsentCount' => $yearAbsentCount,
            ],
        ]);
    }
}
