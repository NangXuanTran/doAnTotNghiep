<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $classesThisMonth = Classroom::whereMonth('created_at', now()->month)->get();
        $countTeacherThisMonth = Classroom::whereMonth('created_at', now()->month)->selectRaw('COUNT(DISTINCT teacher_id) AS teacher_count')
            ->whereHas('teacher')
            ->first()
            ->teacher_count;

        $countRevenueMonth = 0;
        $countClassThisMonth = count($classesThisMonth);
        $countStudentThisMonth = 0;
        foreach ($classesThisMonth as $classThisMonth) {
            $countRevenueMonth += count($classThisMonth->students) * $classThisMonth->fee;
            $countStudentThisMonth += count($classThisMonth->students);
        }

        $lastMonthStart = now()->subMonth()->startOfMonth();
        $lastMonthEnd = now()->subMonth()->endOfMonth();
        $classesLastMonth = Classroom::whereDate('created_at', '>=', $lastMonthStart)->whereDate('created_at', '<=', $lastMonthEnd)->get();

        $countRevenueLastMonth = 0;
        $countClassLastMonth = count($classesLastMonth);
        $countStudentLastMonth = 0;
        $countTeacherLastMonth = Classroom::whereDate('created_at', '>=', $lastMonthStart)
            ->whereDate('created_at', '<=', $lastMonthEnd)
            ->selectRaw('COUNT(DISTINCT teacher_id) AS teacher_count')
            ->whereHas('teacher')
            ->first()
            ->teacher_count;
        foreach ($classesLastMonth as $classLastMonth) {
            $countRevenueLastMonth += count($classLastMonth->students) * $classLastMonth->fee;
            $countStudentLastMonth += count($classLastMonth->students);
        }

        $growRevenue = 999999999;
        $growClass = 999999999;
        $growStudent = 999999999;
        $growTeacher= 999999999;
        if($countRevenueLastMonth && $countClassLastMonth && $countStudentLastMonth && $countTeacherLastMonth) {
            $growRevenue = round(($countRevenueMonth - $countRevenueLastMonth) / $countRevenueLastMonth * 100);
            $growClass = round(($countClassThisMonth - $countClassLastMonth) / $countClassLastMonth * 100);
            $growStudent = round(($countStudentThisMonth - $countStudentLastMonth) / $countStudentLastMonth * 100);
            $growTeacher = round(($countTeacherThisMonth - $countTeacherLastMonth) / $countTeacherLastMonth * 100);
        }

        $countsLast12Months = [];
        $currentMonth = now();
        for ($i = 0; $i < 12; $i++) {
            $startOfMonth = now()->subMonth($i)->startOfMonth();
            $endOfMonth = now()->subMonth($i)->endOfMonth();
            $classesLastMonth = Classroom::whereDate('created_at', '>=', $lastMonthStart)->whereDate('created_at', '<=', $lastMonthEnd)->get();
            $countRevenue = 0;
            $countClass = count($classesLastMonth);
            $countStudent = 0;
            $countTeacher = Classroom::whereDate('created_at', '>=', $startOfMonth)
                ->whereDate('created_at', '<=', $endOfMonth)
                ->selectRaw('COUNT(DISTINCT teacher_id) AS teacher_count')
                ->whereHas('teacher')
                ->first()
                ->teacher_count;

            foreach ($classesLastMonth as $classLastMonth) {
                $countRevenue += count($classLastMonth->students) * $classLastMonth->fee;
                $countStudent += count($classLastMonth->students);
            }

            $countsLast12Months[] = [
                'startOfMonth' => $startOfMonth,
                'endOfMonth' => $endOfMonth,
                'countRevenue' => $countRevenue,
                'countClass' => $countClass,
                'countStudent' => $countStudent,
                'countTeacher' => $countTeacher
            ];
        }

        dd($countsLast12Months);

        return view('dashboard', compact(
            'countRevenueMonth', 'countClassThisMonth', 'countStudentThisMonth', 'countTeacherThisMonth',
            'growRevenue', 'growClass', 'growStudent', 'growTeacher'
        ));
    }
}
