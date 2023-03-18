<?php

namespace App\Http\Controllers\Feature;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Project;

class DashboardController extends Controller
{
    public function index() {
        $getDataProjectStatus = Project::getDataProjectStatus();
        $chartData = [
            'type' => 'pie',
            'title' => 'Project Data by Status',
            'labels' => ['Project Not Started', 'Project In Progress', 'Project Completed'],
            'data' => [$getDataProjectStatus['projectNotStarted'], $getDataProjectStatus['projectInProgress'], $getDataProjectStatus['projectCompleted']],
            'bgColor' => ['rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(255, 205, 86)']
        ];

        $getProjectInProgress = Project::getProjectInProgress();

        return view('feature.dashboard', compact('chartData', 'getProjectInProgress'));
    }
}
