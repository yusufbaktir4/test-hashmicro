<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cek 2 Free Input') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <form action="#" method="POST" id="myform">
                    <div class="overflow-hidden shadow sm:rounded-md">
                        <div class="bg-white px-4 py-5 sm:p-6">
                            <div class="flex justify-center text-center">
                                <div class="px-3 py-2">
                                    <label for="input-1" class="block text-sm font-medium leading-6 text-gray-900">Input 1</label>
                                    <input type="text" name="input-1" id="input-1" autocomplete="off" class="mt-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>

                                <div class="px-3 py-2">
                                    <label for="input-2" class="block text-sm font-medium leading-6 text-gray-900">Input 2</label>
                                    <input type="text" name="input-2" id="input-2" autocomplete="off" class="mt-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>

                            <div class="flex justify-center">
                                <div class="px-3 py-10">
                                    <button type="button" id="btn-check" class="inline-flex justify-center rounded-md bg-indigo-600 py-2 px-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Submit</button>
                                </div>

                                <div class="py-10">
                                    <button type="button" id="btn-reset" class="inline-flex justify-center rounded-md bg-red-600 py-2 px-3 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-500">Reset</button>
                                </div>
                            </div>

                            <div class="flex justify-center">
                                <div class="px-3 py-2">
                                    <label class="block text-lg leading-12 text-gray-900">Result: <b><span id="result">-</span></b></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script type="text/javascript">
    $(document).ready(function() {
        $("#btn-check").click(function() {
            var input1 = $("#input-1").val().toLowerCase();
            var input2 = $("#input-2").val().toLowerCase();
            var count = 0;
            for (var i = 0; i < input1.length; i++) {
                if (input2.includes(input1[i])) {
                    count++;
                }
            }
            var percent = (count / input1.length) * 100;
            $("#result").text(percent.toFixed(2) + "%");
        });

        $("#btn-reset").click(function() {
            $(':input','#myform')
            .not(':button, :submit, :reset, :hidden')
            .val('');

            $("#myform input:text").first().focus();

            $("#result").text("-");
        });
    });
</script>
