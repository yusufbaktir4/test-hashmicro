<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Task for ' . $projectData->nama_proyek) }}
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

                        <form action="{{ $actionForm }}" method="POST" class="w-full max-w-lg">
                            @csrf

                            <?php if (isset($taskData)): ?>
                                @method('PUT')
                            <?php endif ?>

                            <div class="mb-4">
                                <label class="block text-gray-700 font-bold mb-2" for="nama_task">
                                    Task Name
                                </label>
                                <input class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nama_task" name="nama_task" type="text" value="{{$taskData['nama_task'] ?? old('nama_task')}}" placeholder="Task Name">

                                @error('nama_task')
                                    <p class="text-red-500 mt-2 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 font-bold mb-2" for="description">
                                    Description
                                </label>
                                <textarea id="description" name="description" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" rows="8" placeholder="Enter description here...">{{$taskData['description'] ?? old('description')}}</textarea>

                                @error('description')
                                    <p class="text-red-500 mt-2 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 font-bold mb-2" for="user_id">
                                    Assign To
                                </label>
                                <select class="form-select block w-full mt-1 select2" id="user_id" name="user_id">
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
                                    <p class="text-red-500 mt-2 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center justify-between">
                                <input type="hidden" name="projectUuid" value="{{request()->route('projectUuid') ?? $projectData->uuid}}">
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