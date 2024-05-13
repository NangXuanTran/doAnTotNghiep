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

        $growRevenue = round(($countRevenueMonth - $countRevenueLastMonth) / $countRevenueLastMonth * 100);
        $growClass = round(($countClassThisMonth - $countClassLastMonth) / $countClassLastMonth * 100);
        $growStudent = round(($countStudentThisMonth - $countStudentLastMonth) / $countStudentLastMonth * 100);
        $growTeacher = round(($countTeacherThisMonth - $countTeacherLastMonth) / $countTeacherLastMonth * 100);

        return view('dashboard', compact(
            'countRevenueMonth', 'countClassThisMonth', 'countStudentThisMonth', 'countTeacherThisMonth',
            'growRevenue', 'growClass', 'growStudent', 'growTeacher'
        ));
    }
}
