<?php

namespace App\Http\Controllers\Web;

use App\Enums\TaskStatus;
use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    private const TTL = 300;
    public function index(){
        $userId = auth()->id();

        $stats = Cache::remember("dashboard:stats:{$userId}", self::TTL, function() use($userId){
            return [
                'total' => Task::where('user_id', $userId)->count(),
                'pending' => Task::where('user_id', $userId)->where('status', TaskStatus::PENDING)->count(),
                'inProgress' => Task::where('user_id', $userId)->where('status', TaskStatus::IN_PROGRESS)->count(),
                'completed' => Task::where('user_id', $userId)->where('status', TaskStatus::COMPLETED)->count(),
            ];
        });

        $recentTasks = Cache::remember("dashboard:recent:{$userId}", self::TTL, function() use($userId){
            return Task::where('user_id', $userId)->latest()->take(5)->get();
        });

        return view('dashboard.index', [
            'total' => $stats['total'],
            'pending' => $stats['pending'],
            'inProgress' => $stats['inProgress'],
            'completed' => $stats['completed'],
            'recentTasks' => $recentTasks,
        ]);
    }

    public static function clearCache(string $userId){
        Cache::forget("dashboard:stats:{$userId}");
        Cache::forget("dashboard:recent:{$userId}");
    }
}
