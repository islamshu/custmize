@extends('layouts.master')

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('Main setting info') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('Main setting info') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-body">
                <section id="validation">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ __('Main setting info') }}</h4>
                                </div>
                                <div class="card-content collpase show">
                                    <div class="card-body">
                                        <form class="form" action="{{ route('add_general') }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-body">
                                                <div class="row">
                                                    <!-- Factor 1 -->
                                                    <div class="form-group col-md-4 mb-2">
                                                        <label for="input_factor_1">{{ __('Input Factor 1') }}</label>
                                                        <input type="number" id="input_factor_1" class="form-control border-primary" placeholder="{{ __('Factor 1') }}" name="general[input_factor_1]" required oninput="updateEquation()">
                                                    </div>

                                                    <!-- Factor 2 (Optional, not used in the equation) -->
                                                    <div class="form-group col-md-4 mb-2">
                                                        <label for="input_factor_2">{{ __('Input Factor 2') }}</label>
                                                        <input type="number" id="input_factor_2" class="form-control border-primary" placeholder="{{ __('Factor 2') }}" name="general[input_factor_2]">
                                                    </div>

                                                    <!-- Factor 3 (Optional, not used in the equation) -->
                                                    <div class="form-group col-md-4 mb-2">
                                                        <label for="input_factor_3">{{ __('Input Factor 3') }}</label>
                                                        <input type="number" id="input_factor_3" class="form-control border-primary" placeholder="{{ __('Factor 3') }}" name="general[input_factor_3]">
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="form-group col-md-12 mb-2">
                                                        <h4 id="equation_display"></h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // Define the labels for logo length and width
        var logoLengthLabel = "طول اللوجو";  // Label for logo length
        var logoWidthLabel = "عرض اللوجو";  // Label for logo width

        // Function to update the equation when the factor 1 changes
        function updateEquation() {
            // Get the value of Factor 1
            var inputFactor1 = document.getElementById('input_factor_1').value;

            // Display the updated equation using the labels
            document.getElementById('equation_display').innerHTML = 
                "المعادلة: " + logoLengthLabel + " × " + logoWidthLabel + " × " + inputFactor1 + " = ؟";
        }

        // Call the function to initialize the equation when the page loads
        updateEquation();
    </script>
@endsection
