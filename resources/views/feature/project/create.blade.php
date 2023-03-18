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

                        <h2 class="card-title">Project Form</h2>
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

                            <?php if (isset($projectData)): ?>
                                @method('PUT')
                            <?php endif ?>

                            <div class="mb-4 form-group">
                                <label class="col-form-label" for="nama_proyek">
                                    Project Name
                                </label>
                                <input class="form-control" id="nama_proyek" name="nama_proyek" type="text" value="{{$projectData['nama_proyek'] ?? old('nama_proyek')}}" placeholder="Project Name">

                                @error('nama_proyek')
                                    <label class="error" for="nama_proyek">{{ $message}}</label>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="col-form-label" for="start_date">
                                    Start Date
                                </label>
                                <input type="text" autocomplete="off" class="form-control datepicker" id="start_date" name="start_date" value="{{ !is_null(old('start_date')) ? \Carbon\Carbon::parse(old('start_date'))->format('Y-m-d') : (isset($projectData['start_date']) ? \Carbon\Carbon::parse($projectData['start_date'])->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d')) }}">

                                @error('start_date')
                                    <label class="error" for="start_date">{{ $message}}</label>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="col-form-label" for="end_date">
                                    End Date
                                </label>
                                <input type="text" autocomplete="off" class="form-control datepicker" id="end_date" name="end_date" value="{{ !is_null(old('end_date')) ? \Carbon\Carbon::parse(old('end_date'))->format('Y-m-d') : (isset($projectData['end_date']) ? \Carbon\Carbon::parse($projectData['end_date'])->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d')) }}">

                                @error('end_date')
                                    <label class="error" for="end_date">{{ $message}}</label>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="col-form-label" for="payment_status">
                                    Payment Status
                                </label>
                                <select class="form-control" id="payment_status" name="payment_status">
                                    <?php if (!isset($projectData) && old('payment_status') == ''): ?>
                                        <option value="">Choose Payment Status</option>
                                        <?php foreach ($paymentStatuses as $keyStatus => $valueStatus): ?>
                                                <option value="{{$keyStatus}}">{{$valueStatus}}</option>
                                        <?php endforeach ?>
                                    <?php else: ?>
                                        <?php foreach ($paymentStatuses as $keyStatus => $valueStatus): ?>
                                            <?php if ((isset($projectData['payment_status']) && $projectData['payment_status'] == $keyStatus) || (old('payment_status') != '' && old('payment_status') == $keyStatus)): ?>
                                                <option value="{{$keyStatus}}" selected>{{$valueStatus}}</option>
                                            <?php else: ?>
                                                <option value="{{$keyStatus}}">{{$valueStatus}}</option>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </select>

                                @error('payment_status')
                                    <label class="error" for="payment_status">{{ $message}}</label>
                                @enderror
                            </div>

                            <footer class="card-footer text-start mt-2">
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