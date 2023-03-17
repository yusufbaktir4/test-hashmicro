<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        return view('dashboard', compact('chartData', 'getProjectInProgress'));
    }
}
