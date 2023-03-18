<?php 
use App\Models\Project;
?>

@extends('feature.layouts.layout')

@section('content')
    <section role="main" class="content-body">
        <header class="page-header">
            <h2>Create Project</h2>

            <div class="right-wrapper text-end">
                <ol class="breadcrumbs" style="margin-right: 0.5rem !important;">
                    <li>
                        <a href="{{route('home')}}">
                            <i class="bx bx-home-alt"></i>
                        </a>
                    </li>

                    <li><span>Create Project</span></li>
                </ol>
            </div>
        </header>

        <div class="row">
            <div class="col">
                <section class="card">
                    <header class="card-header">
                        <div class="card-actions">
                            <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                            <a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
                        </div>

                        <h2 class="card-title">{{$projectData->nama_proyek}}</h2>
                    </header>
                    <div class="card-body">

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success!</strong> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true" aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="row mb-4">
                            <div class="col-sm-2">
                                <a href="{{route('feature.task.create', ['projectUuid' => $projectData->uuid])}}" class="btn btn-success">Create Task</a>
                            </div>
                            
                            <div class="col-sm-2">
                                <?php if ($projectData->status == $projectData::PROJECT_STATUS_NOT_STARTED): ?>
                                    <form method="POST" action="{{route('feature.project.changestate', ['project' => $projectData->uuid, 'status' => $projectData::PROJECT_STATUS_IN_PROGRESS])}}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        
                                        <button type="submit" onclick="return confirm('Are you sure to start this project?')" class="btn btn-primary">Start Project</button>
                                    </form>
                                <?php endif ?>
                            </div>                            
                        </div>

                        <h2 class="card-title mb-2">Progress: </h2>
                        <div class="progress progress-xl progress-half-rounded m-2 mb-4">
                            <div class="progress-bar" role="progressbar" aria-valuenow="{{ $projectData::getPersenCompleteProject($projectData) }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $projectData::getPersenCompleteProject($projectData) }}%;">
                                {{ $projectData::getPersenCompleteProject($projectData) }}%
                            </div>
                        </div>

                        <table role="grid" style="width: 100%;">
                            <tr role="row" class="odd">
                                <td class="border px-4 py-2 font-semibold">Project Name</td>
                                <td class="border px-4 py-2">{{$projectData->nama_proyek}}</td>
                            </tr>

                            <tr role="row" class="odd">
                                <td class="border px-4 py-2 font-semibold">Start Date</td>
                                <td class="border px-4 py-2">{{Project::dateFormat($projectData->start_date)}}</td>
                            </tr>

                            <tr role="row" class="odd">
                                <td class="border px-4 py-2 font-semibold">End Date</td>
                                <td class="border px-4 py-2">{{Project::dateFormat($projectData->end_date)}}</td>
                            </tr>

                            <tr role="row" class="odd">
                                <td class="border px-4 py-2 font-semibold">Project Status</td>
                                <td class="border px-4 py-2">{{ Project::getProjectStatus($projectData)}}</td>
                            </tr>

                            <tr role="row" class="odd">
                                <td class="border px-4 py-2 font-semibold">Created At</td>
                                <td class="border px-4 py-2">{{Project::dateFormat($projectData->created_at)}}</td>
                            </tr>

                            <tr role="row" class="odd">
                                <td class="border px-4 py-2 font-semibold">Created By</td>
                                <td class="border px-4 py-2">{{$projectData->created_by}}</td>
                            </tr>

                            <tr role="row" class="odd">
                                <td class="border px-4 py-2 font-semibold">Updated At</td>
                                <td class="border px-4 py-2">{{Project::dateFormat($projectData->updated_at)}}</td>
                            </tr>

                            <tr role="row" class="odd">
                                <td class="border px-4 py-2 font-semibold">Updated By</td>
                                <td class="border px-4 py-2">{{$projectData->updated_by}}</td>
                            </tr>
                        </table>

                        <?php if ($projectData->tasks()->count() > 0): ?>
                            <h2 class="card-title mt-4 mb-2">Detail Task</h2>

                            <div class="col" style="overflow-x: scroll;">
                                {{$taskDt->html()->table(['class' => 'min-w-full divide-y divide-gray-200 w-full'])}}
                            </div>
                        <?php endif ?>
                    </div>
                </section>
            </div>
        </div>
        <!-- end: page -->
    </section>
@endsection

@section('add_js')
<script type="text/javascript">
    {!!  $taskDt->html()->generateScripts() !!}
</script>
@endsection