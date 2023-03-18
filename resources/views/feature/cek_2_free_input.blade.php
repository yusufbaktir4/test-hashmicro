@extends('feature.layouts.layout')

@section('content')
<section role="main" class="content-body">
        <header class="page-header">
            <h2>Cek 2 Free Input</h2>

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
        
        <section class="card">
            <header class="card-header">
                <div class="card-actions">
                    <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                    <a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
                </div>

                <h2 class="card-title">Cek</h2>
            </header>

            <form id="myform">
                <div class="card-body">
                    <div class="row form-group pb-3">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-form-label" for="input-1">Input 1</label>
                                <input type="text" class="form-control" id="input-1" name="input-1" placeholder="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-form-label" for="input-2">Input 2</label>
                                <input type="text" class="form-control" id="input-2" name="input-2" placeholder="">
                            </div>
                        </div>
                    </div>

                    <div class="form-group pb-3 text-center">
                        <label class="block text-lg leading-12 text-gray-900">Result: <b><span id="result">-</span></b></label>
                    </div>
                </div>
                <footer class="card-footer text-center">
                    <button class="btn btn-success" type="button" id="btn-reset">Reset</button>
                    <button class="btn btn-primary" type="button" id="btn-check">Submit</button>
                </footer>
            </form>
        </section> 
</section>
@endsection

@section('add_js')
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
@endsection