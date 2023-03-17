<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Project') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="overflow-hidden shadow sm:rounded-md">
                    <div class="bg-white px-4 py-5 sm:p-6">
                        <form action="{{ $actionForm }}" method="POST" class="w-full max-w-lg">
                            @csrf

                            <?php if (isset($projectData)): ?>
                                @method('PUT')
                            <?php endif ?>

                            <div class="mb-4">
                                <label class="block text-gray-700 font-bold mb-2" for="nama_proyek">
                                    Project Name
                                </label>
                                <input class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nama_proyek" name="nama_proyek" type="text" value="{{$projectData['nama_proyek'] ?? old('nama_proyek')}}" placeholder="Project Name">

                                @error('nama_proyek')
                                    <p class="text-red-500 mt-2 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 font-bold mb-2" for="start_date">
                                    Start Date
                                </label>
                                <input class="form-input block w-full mt-1" type="datetime-local" id="start_date" name="start_date" value="{{ isset($projectData['start_date']) ? \Carbon\Carbon::parse($projectData['start_date'])->format('Y-m-d\TH:i:s') : (!is_null(old('start_date')) ? \Carbon\Carbon::parse(old('start_date'))->format('Y-m-d\TH:i:s') : \Carbon\Carbon::now()->format('Y-m-d\TH:i:s')) }}">

                                @error('start_date')
                                    <p class="text-red-500 mt-2 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 font-bold mb-2" for="end_date">
                                    End Date
                                </label>
                                <input class="form-input block w-full mt-1" type="datetime-local" id="end_date" name="end_date" value="{{ isset($projectData['end_date']) ? \Carbon\Carbon::parse($projectData['end_date'])->format('Y-m-d\TH:i:s') : (!is_null(old('end_date')) ? \Carbon\Carbon::parse(old('end_date'))->format('Y-m-d\TH:i:s') : \Carbon\Carbon::now()->format('Y-m-d\TH:i:s')) }}">

                                @error('end_date')
                                    <p class="text-red-500 mt-2 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 font-bold mb-2" for="email">
                                    Payment Status
                                </label>
                                <select class="form-select block w-full mt-1" id="payment_status" name="payment_status">
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
                                    <p class="text-red-500 mt-2 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center justify-between">
                                <button class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                                    Submit
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>