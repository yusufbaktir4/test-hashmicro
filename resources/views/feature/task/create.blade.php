@extends('feature.layouts.layout')

@section('content')
    <section role="main" class="content-body">
        <header class="page-header">
            <h2>Create Task</h2>

            <div class="right-wrapper text-end">
                <ol class="breadcrumbs" style="margin-right: 0.5rem !important;">
                    <li>
                        <a href="{{route('home')}}">
                            <i class="bx bx-home-alt"></i>
                        </a>
                    </li>

                    <li><span>Create Task</span></li>
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

                        <h2 class="card-title">Create Task for {{$projectData->nama_proyek}}</h2>
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

                        <form action="{{ $actionForm }}" method="POST" class="w-full max-w-lg">
                            @csrf

                            <?php if (isset($taskData)): ?>
                                @method('PUT')
                            <?php endif ?>

                            <div class="mb-4">
                                <label class="col-form-label" for="nama_task">
                                    Task Name
                                </label>
                                <input class="form-control" id="nama_task" name="nama_task" type="text" value="{{$taskData['nama_task'] ?? old('nama_task')}}" placeholder="Task Name">

                                @error('nama_task')
                                    <label class="error" for="nama_task">{{ $message}}</label>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="col-form-label" for="description">
                                    Description
                                </label>
                                <textarea id="description" name="description" class="form-control" rows="8" placeholder="Enter description here...">{{$taskData['description'] ?? old('description')}}</textarea>

                                @error('description')
                                    <label class="error" for="description">{{ $message}}</label>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="col-form-label" for="user_id">
                                    Assign To
                                </label>
                                <select data-plugin-selectTwo class="form-control populate" id="user_id" name="user_id">
                                    <?php if (!isset($taskData) && old('user_id') == ''): ?>
                                        <option value="">Choose User</option>
                                        <?php foreach ($users as $keyUser => $valueUser): ?>
                                                <option value="{{$valueUser->id}}">{{$valueUser->name}}</option>
                                        <?php endforeach ?>
                                    <?php else: ?>
                                        <?php foreach ($users as $keyUser => $valueUser): ?>
                                            <?php if ((isset($taskData['user_id']) && $taskData['user_id'] == $valueUser->id) || (old('user_id') != '' && old('user_id') == $valueUser->id)): ?>
                                                <option value="{{$valueUser->id}}" selected>{{$valueUser->name}}</option>
                                            <?php else: ?>
                                                <option value="{{$valueUser->id}}">{{$valueUser->name}}</option>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </select>

                                @error('user_id')
                                    <label class="error" for="user_id">{{ $message}}</label>
                                @enderror
                            </div>

                            <footer class="card-footer text-start mt-2">
                                <input type="hidden" name="projectUuid" value="{{request()->route('projectUuid') ?? $projectData->uuid}}">
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </footer>
                        </form>
                    </div>
                </section>
            </div>
        </div>
        <!-- end: page -->
    </section>
@endsection