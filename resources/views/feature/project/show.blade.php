<?php 
use App\Models\Project;
?>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Project') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="overflow-hidden shadow sm:rounded-md">
                    <div class="bg-white px-4 py-5 sm:p-6">
                        @if (session('success'))
                            <div class="bg-indigo-500 border-l-4 border-indigo-500 text-white p-4 mb-4" role="alert">
                                <p class="font-bold ml-3">Success</p>
                                <p class="ml-3">{{ session('success') }}</p>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="bg-indigo-500 border-l-4 border-indigo-500 text-white p-4 mb-4" role="alert">
                                <p class="font-bold ml-3">Error!</p>
                                <p class="ml-3">{{ session('error') }}</p>
                            </div>
                        @endif

                        <div class="flex">
                            <div class="py-2 justify-right mr-2">
                                <?php if ($projectData->status == $projectData::PROJECT_STATUS_NOT_STARTED): ?>
                                    <form method="POST" action="{{route('feature.project.changestate', ['project' => $projectData->uuid, 'status' => $projectData::PROJECT_STATUS_IN_PROGRESS])}}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        
                                        <button type="submit" onclick="return confirm('Are you sure to start this project?')" class="inline-flex justify-right rounded-md bg-green-600 py-2 px-3 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-500">Start Project</button>
                                    </form>
                                <?php endif ?>
                            </div>
                            <div class="py-2 justify-right">
                                <a href="{{route('feature.task.create', ['projectUuid' => $projectData->uuid])}}" class="inline-flex justify-right rounded-md bg-indigo-600 py-2 px-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Create Task</a>
                            </div>
                            
                        </div>

                        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                            {{ $projectData->nama_proyek }}
                        </h2>

                        <div class="bg-gray-300 h-2 rounded-full overflow-hidden mb-2">
                            <div class="bg-blue-500 h-full" style="width: {{ $projectData::getPersenCompleteProject($projectData) }}"></div>
                        </div>
                        <h4 class="text-md font-semibold text-black-500 text-center mb-6">{{ $projectData::getPersenCompleteProject($projectData) }} Complete</h4>

                        <table class="min-w-full divide-y divide-gray-200 w-full mb-6">
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
                            <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                                {{ __('Detail Tasks') }}
                            </h2>

                            <div class="col" style="overflow-x: scroll;">
                                {{$taskDt->html()->table(['class' => 'min-w-full divide-y divide-gray-200 w-full'])}}
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script type="text/javascript">
    {!!  $taskDt->html()->generateScripts() !!}
</script>