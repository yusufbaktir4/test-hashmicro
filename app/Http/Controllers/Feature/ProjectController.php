<?php

namespace App\Http\Controllers\Feature;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Feature\ProjectDataTable;
use App\Models\Project;
use App\Services\ProjectService;
use App\DataTables\Feature\TaskDataTable;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProjectDataTable $projectDt)
    {
        return $projectDt->render('feature.project.index', compact('projectDt'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $actionForm = route('feature.project.store');
        $paymentStatuses = Project::getPaymentStatusMap();
        return view('feature.project.create', compact('actionForm', 'paymentStatuses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'nama_proyek' => 'required|string',
            'start_date' => 'required|date_format:Y-m-d|after:yesterday',
            "end_date" => "required|date_format:Y-m-d|after:start_date",
            "payment_status" => "required"
        ],
        [
            'nama_proyek.required' => "Project Name can't be blank",
            'start_date.required' => "Start Date can't be blank",
            'end_date.required' => "End Date can't be blank",
            'payment_status.required' => "Payment Status must be selected one",
            'start_date.after' => 'Start Date cannot be less than today (Today: '.date("d/m/Y").')',
            'end_date.after' => 'End Date cannot be less than Start Date',
        ]);

        $response = (new ProjectService)->saveToDB($request);

        if($response['valid']) {
            return redirect()->route('feature.project.index')->with('success', $response['msg']);
        } else {
            return redirect()->route('feature.project.index')->with('error', $response['msg']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $projectData = Project::where('uuid', $id)->first();
        $taskDt = new TaskDataTable($id);

        if(is_null($projectData)) {
            return redirect()->route('feature.project.index')->with('error', 'Project not found');
        } else {
            return $taskDt->render('feature.project.show', compact('projectData', 'taskDt'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $projectData = Project::where('uuid', $id)->first();
        $actionForm = route('feature.project.update', ['project' => $id]);
        $paymentStatuses = Project::getPaymentStatusMap();

        if(is_null($projectData)) {
            return redirect()->route('feature.project.index')->with('error', 'Project not found');
        } else {
            return view('feature.project.create', compact('actionForm', 'paymentStatuses', 'projectData'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = $request->validate([
            'nama_proyek' => 'required|string',
            'start_date' => 'required|date_format:Y-m-d|after:yesterday',
            "end_date" => "required|date_format:Y-m-d|after:start_date",
            "payment_status" => "required"
        ],
        [
            'nama_proyek.required' => "Project Name can't be blank",
            'start_date.required' => "Start Date can't be blank",
            'end_date.required' => "End Date can't be blank",
            'payment_status.required' => "Payment Status must be selected one",
            'start_date.after' => 'Start Date cannot be less than today (Today: '.date("d/m/Y").')',
            'end_date.after' => 'End Date cannot be less than Start Date',
        ]);

        $response = (new ProjectService($id))->saveToDB($request);

        if($response['valid']) {
            return redirect()->route('feature.project.index')->with('success', $response['msg']);
        } else {
            return redirect()->route('feature.project.index')->with('error', $response['msg']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = (new ProjectService($id))->deleteFromDB();

        if($response['valid']) {
            return redirect()->route('feature.project.index')->with('success', $response['msg']);
        } else {
            return redirect()->route('feature.project.index')->with('error', $response['msg']);
        }
    }

    public function changeStateProject($uuidProject, $status) {
        $response = (new ProjectService($uuidProject))->updateStatusProject($status);

        if($response['valid']) {
            return back()->with('success', $response['msg']);
        } else {
            return back()->with('error', $response['msg']);
        }
    }
}
