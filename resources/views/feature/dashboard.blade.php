@extends('feature.layouts.layout')

@section('content')
    <section role="main" class="content-body">
        <header class="page-header">
            <h2>Dashboard</h2>

            <div class="right-wrapper text-end">
                <ol class="breadcrumbs" style="margin-right: 0.5rem !important;">
                    <li>
                        <a href="{{route('home')}}">
                            <i class="bx bx-home-alt"></i>
                        </a>
                    </li>
                </ol>
            </div>
        </header>

        <!-- start: page -->
        <section class="card">
            <header class="card-header">
                <div class="card-actions">
                    <a href="#" class="card-action card-action-toggle" data-card-toggle=""></a>
                    <a href="#" class="card-action card-action-dismiss" data-card-dismiss=""></a>
                </div>

                <h5>Hi, {{Auth::user()->email}}</h5>
            </header>

            <div class="card-body">
                <p>
                    Welcome to Dashboard! <BR>
                    There are statistical data below. <BR><BR>

                    - Nested Loop is in "Project In Progress on Dashboard page" feature <BR>
                    - Nested if is in "Displaying Project Status on Project Details page" feature <BR>
                    - Mathematics is in the "Display chart on the Dashboard page and display Progress on the Dashboard page and Project Detail page" <BR>
                    - CRUD is in the Project feature <BR>
                </p>
            </div>
        </section>

        <section class="card">
            <header class="card-header">
                <div class="card-actions">
                    <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                    <a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
                </div>

                <h2 class="card-title">{{$chartData['title']}}</h2>
            </header>
            <div class="card-body">
                @include('feature.global_components.chart')
            </div>
        </section>

        <section class="card">
            <header class="card-header">
                <div class="card-actions">
                    <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                    <a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
                </div>

                <h2 class="card-title">{{$chartData['title']}}</h2>
            </header>
            <div class="card-body">
                <table style="width: 100%;" role="grid" >
                    <thead>
                        <tr>
                            <td class="border px-4 py-2 text-center">No.</td>
                            <td class="border px-4 py-2 text-center">Nama Project</td>
                            <td class="border px-4 py-2 text-center">Progress</td>
                            <td class="border px-4 py-2 text-center">Team</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($getProjectInProgress as $key => $value): ?>
                            <tr>
                                <td class="border px-4 py-2">{{$key + 1}}</td>
                                <td class="border px-4 py-2">{{$value['projectName']}}</td>
                                <td class="border px-4 py-2">
                                    <div class="progress progress-xl progress-half-rounded m-2">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="{{ $value['progress'] }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $value['progress'] }}%;">
                                            {{ $value['progress'] }}%
                                        </div>
                                    </div>
                                </td>
                                <td class="border px-4 py-2">
                                    <?php foreach ($value['users'] as $keyUser => $valueUser): ?>
                                        <p>{{"- " . $valueUser}}</p>
                                    <?php endforeach ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </section>
        <!-- end: page -->
    </section>
@endsection