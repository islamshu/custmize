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
                                        <form class="form" action="{{ route('add_general') }}" method="POST">
                                            @csrf
                                            <div class="form-body">
                                                <div class="row">
                                                    <!-- Length -->
                                                    <div class="form-group col-md-3 mb-2">
                                                        <label for="input_length">{{ __('الطول') }}</label>
                                                        <input type="number" step="0.01" disabled id="input_length" value="10" name="general[length]" class="form-control border-primary" placeholder="{{ __('Length') }}" oninput="calculateEquation()">
                                                    </div>

                                                    <!-- Width -->
                                                    <div class="form-group col-md-3 mb-2">
                                                        <label for="input_width">{{ __('العرض') }}</label>
                                                        <input type="number" step="0.01" disabled id="input_width" value="5" name="general[width]" class="form-control border-primary" placeholder="{{ __('Width') }}" oninput="calculateEquation()">
                                                    </div>

                                                    <!-- Percentage -->
                                                    <div class="form-group col-md-3 mb-2">
                                                        <label for="input_percentage">{{ __('النسبة') }}</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.01" id="input_percentage" value="{{get_general_value('percentage')}}" name="general[percentage]" class="form-control border-primary" placeholder="{{ __('Percentage') }}" oninput="calculateEquation()">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">%</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Threshold -->
                                                    <div class="form-group col-md-3 mb-2">
                                                        <label for="input_threshold">{{ __('القيمة المرتبطة بالناتج') }}</label>
                                                        <input type="number" step="0.01" id="input_threshold" value="{{get_general_value('threshold')}}" name="general[threshold]" class="form-control border-primary" placeholder="{{ __('Threshold') }}" oninput="calculateEquation()">
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <!-- Equation Display -->
                                                    <div class="form-group col-md-12 mb-2">
                                                        <h4 id="equation_display"></h4>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <!-- Price for Less -->
                                                    <div class="form-group col-md-4 mb-2">
                                                        <label for="input_price_less">{{ __('السعر عند الناتج أقل') }}</label>
                                                        <input type="number" step="0.01" id="input_price_less" value="{{get_general_value('price_less')}}" name="general[price_less]" class="form-control border-primary" placeholder="{{ __('Price for Less') }}" oninput="calculateEquation()">
                                                    </div>

                                                    <!-- Price for Equal -->
                                                    <div class="form-group col-md-4 mb-2">
                                                        <label for="input_price_equal">{{ __('السعر عند الناتج مساوي') }}</label>
                                                        <input type="number" step="0.01" id="input_price_equal" value="{{get_general_value('price_equal')}}" name="general[price_equal]" class="form-control border-primary" placeholder="{{ __('Price for Equal') }}" oninput="calculateEquation()">
                                                    </div>

                                                    <!-- Price for Greater -->
                                                    {{-- <div class="form-group col-md-4 mb-2">
                                                        <label for="input_price_greater">{{ __('السعر عند الناتج أكبر') }}</label>
                                                        <input type="number" step="0.01" id="input_price_greater" value="{{get_general_value('price_greater')}}" name="general[price_greater]" class="form-control border-primary" placeholder="{{ __('Price for Greater') }}" oninput="calculateEquation()">
                                                    </div> --}}
                                                </div>

                                                <div class="row">
                                                    <!-- Result -->
                                                    <div class="form-group col-md-12 mb-2">
                                                        <h4 id="comparison_result"></h4>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <!-- Save Button -->
                                                    <div class="form-group col-md-12 mb-2">
                                                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
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
        function calculateEquation() {
            // Get values from inputs
            var length = parseFloat(document.getElementById('input_length').value) || 0;
            var width = parseFloat(document.getElementById('input_width').value) || 0;
            var percentage = parseFloat(document.getElementById('input_percentage').value) || 0;
            var threshold = parseFloat(document.getElementById('input_threshold').value) || 0;
            var priceLess = parseFloat(document.getElementById('input_price_less').value) || 0;
            var priceEqual = parseFloat(document.getElementById('input_price_equal').value) || 0;
            // var priceGreater = parseFloat(document.getElementById('input_price_greater').value) || 0;

            // Convert percentage to decimal
            var percentageDecimal = percentage ;

            // Calculate the result
            var result = length * width * percentageDecimal;

            // Display the equation
            document.getElementById('equation_display').innerHTML = 
                "المعادلة: " + length + " × " + width + " × (" + percentage + ") = " + result.toFixed(2);

            // Prepare the results for all cases
            var lessMessage = "الناتج: " + result.toFixed(2) + " أصغر من العامل (" + threshold + "). السعر: " + priceLess;
            var equalMessage = "الناتج: " + result.toFixed(2) + " مساوي للعامل (" + threshold + "). السعر: " + priceEqual;
            var greaterMessage = "الناتج: " + result.toFixed(2) + " أكبر من العامل (" + threshold + "). السعر: " + result.toFixed(2);

            // Display all results
            document.getElementById('comparison_result').innerHTML = `
                <ul>
                    <li>${lessMessage}</li>
                    <li>${equalMessage}</li>
                    <li>${greaterMessage}</li>
                </ul>
            `;
        }

        // Initialize the equation display on page load
        calculateEquation();
    </script>
@endsection

