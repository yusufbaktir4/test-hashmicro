<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Project') }}
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

                        <div class="py-2 justify-right">
                            <a href="{{route('feature.project.create')}}" class="inline-flex justify-right rounded-md bg-indigo-600 py-2 px-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Create Project</a>
                        </div>

                        <div class="col" style="overflow-x: auto;">
                            {{$projectDt->html()->table(['class' => 'min-w-full divide-y divide-gray-200 w-full'])}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


<script type="text/javascript">
    {!!  $projectDt->html()->generateScripts() !!}
</script>