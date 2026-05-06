<?php

namespace App\Http\Controllers\Web;

use App\Enums\TaskStatus;
use App\Http\Controllers\Controller;
use App\Models\Task;

class DashboardController extends Controller
{
    public function index(){
        $userId = auth()->id();

        return view('dashboard.index', [
            'total' => Task::where('user_id', $userId)->count(),
            'pending' => Task::where('user_id', $userId)->where('status', TaskStatus::PENDING)->count(),
            'inProgress' => Task::where('user_id', $userId)->where('status', TaskStatus::IN_PROGRESS)->count(),
            'completed' => Task::where('user_id', $userId)->where('status', TaskStatus::COMPLETED)->count(),
            'recentTasks' => Task::where('user_id', $userId)->latest()->take(5)->get(),
        ]);
    }
}
