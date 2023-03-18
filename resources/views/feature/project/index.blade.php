@extends('feature.layouts.layout')

@section('content')
    <section role="main" class="content-body">
        <header class="page-header">
            <h2>Bagian</h2>

            <div class="right-wrapper text-end">
                <ol class="breadcrumbs" style="margin-right: 0.5rem !important;">
                    <li>
                        <a href="{{route('home')}}">
                            <i class="bx bx-home-alt"></i>
                        </a>
                    </li>

                    <li><span>Project</span></li>
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

                        <h2 class="card-title">Project Table</h2>
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

                        <div class="col text-start">
                            <a href="{{route('feature.project.create')}}" class="mb-2 mt-1 me-1 btn btn-primary"><i class="fas fa-plus-circle"></i> Create Project</a>
                        </div>

                        <div class="col" style="overflow-x: auto;">
                            {{$projectDt->html()->table(['class' => 'min-w-full divide-y divide-gray-200 w-full'])}}
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <!-- end: page -->
    </section>
@endsection

@section('add_js')
    <script type="text/javascript">
        {!!  $projectDt->html()->generateScripts() !!}
    </script>
@endsection