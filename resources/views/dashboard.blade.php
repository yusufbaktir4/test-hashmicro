<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-welcome />
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="container">
                    <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                        <h1 class="text-2xl font-medium text-gray-900 mb-4">
                            Project Data By Status
                        </h1>

                        <livewire:chart :data="$chartData" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="container">
                    <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                        <h1 class="text-2xl font-medium text-gray-900 mb-4">
                            Project In Progress
                        </h1>

                        <table class="min-w-full divide-y divide-gray-200 w-full" role="grid" >
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
                                            <div class="bg-gray-300 h-2 rounded-full overflow-hidden mb-2">
                                                <div class="bg-blue-500 h-full" style="width: {{ $value['progress'] }}"></div>
                                            </div>
                                            <h4 class="text-md font-semibold text-black-500 text-center mb-6">{{ $value['progress'] }} Complete</h4>
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
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
