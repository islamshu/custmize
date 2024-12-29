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
                                                        <label for="input_length">{{ __('الطول على سبيل المثال') }}</label>
                                                        <input type="number" step="0.01" id="input_length" value=""  class="form-control border-primary" placeholder="{{ __('Length') }}" oninput="calculateEquation()">
                                                    </div>

                                                    <!-- Width -->
                                                    <div class="form-group col-md-3 mb-2">
                                                        <label for="input_width">{{ __('العرض على سبيل المثال') }}</label>
                                                        <input type="number" step="0.01" id="input_width" value=""  class="form-control border-primary" placeholder="{{ __('Width') }}" oninput="calculateEquation()">
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <!-- Equation Display -->
                                                    <div class="form-group col-md-12 mb-2">
                                                        <h4 id="equation_display"></h4>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <!-- Price for Different Cases -->
                                                    <div class="form-group col-md-4 mb-2">
                                                        <label for="input_price_less_equal_3">{{ __('السعر عند الناتج أقل أو يساوي 3') }}</label>
                                                        <input type="number" step="0.01" id="input_price_less_equal_3" value="{{get_general_value('price_less_equal_3')}}" name="general[price_less_equal_3]" class="form-control border-primary" placeholder="{{ __('Price for <= 3') }}" oninput="calculateEquation()">
                                                    </div>

                                                    <div class="form-group col-md-4 mb-2">
                                                        <label for="input_price_3_to_8">{{ __('السعر عند الناتج أكبر من 3 وأقل أو يساوي 8') }}</label>
                                                        <input type="number" step="0.01" id="input_price_3_to_8" value="{{get_general_value('price_3_to_8')}}" name="general[price_3_to_8]" class="form-control border-primary" placeholder="{{ __('Price for >3 and <=8') }}" oninput="calculateEquation()">
                                                    </div>

                                                    <div class="form-group col-md-4 mb-2">
                                                        <label for="input_price_8_to_15">{{ __('السعر عند الناتج أكبر من 8 وأقل أو يساوي 15') }}</label>
                                                        <input type="number" step="0.01" id="input_price_8_to_15" value="{{get_general_value('price_8_to_15')}}" name="general[price_8_to_15]" class="form-control border-primary" placeholder="{{ __('Price for >8 and <=15') }}" oninput="calculateEquation()">
                                                    </div>

                                                    <div class="form-group col-md-4 mb-2">
                                                        <label for="input_price_15_to_21">{{ __('السعر عند الناتج أكبر من 15 وأقل أو يساوي 21') }}</label>
                                                        <input type="number" step="0.01" id="input_price_15_to_21" value="{{get_general_value('price_15_to_21')}}" name="general[price_15_to_21]" class="form-control border-primary" placeholder="{{ __('Price for >15 and <=21') }}" oninput="calculateEquation()">
                                                    </div>

                                                    <div class="form-group col-md-4 mb-2">
                                                        <label for="input_price_21_to_30">{{ __('السعر عند الناتج أكبر من 21 وأقل أو يساوي 30') }}</label>
                                                        <input type="number" step="0.01" id="input_price_21_to_30" value="{{get_general_value('price_21_to_30')}}" name="general[price_21_to_30]" class="form-control border-primary" placeholder="{{ __('Price for >21 and <=30') }}" oninput="calculateEquation()">
                                                    </div>

                                                    <div class="form-group col-md-4 mb-2">
                                                        <label for="input_price_greater_30">{{ __('السعر عند الناتج أكبر من 30') }}</label>
                                                        <input type="number" step="0.01" id="input_price_greater_30" readonly class="form-control border-primary" placeholder="{{ __('Price for >30') }}" oninput="calculateEquation()">
                                                    </div>
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

    var priceLessEqual3 = parseFloat(document.getElementById('input_price_less_equal_3').value) || 0;
    var price3To8 = parseFloat(document.getElementById('input_price_3_to_8').value) || 0;
    var price8To15 = parseFloat(document.getElementById('input_price_8_to_15').value) || 0;
    var price15To21 = parseFloat(document.getElementById('input_price_15_to_21').value) || 0;
    var price21To30 = parseFloat(document.getElementById('input_price_21_to_30').value) || 0;
    var priceGreater30 = parseFloat(document.getElementById('input_price_greater_30').value) || 0;

    // Calculate the area
    var area = length * width;

    // Display the equation
    document.getElementById('equation_display').innerHTML = 
        `المعادلة: ${length} × ${width} = ${area.toFixed(2)}`;

    // Determine the price based on the area
    var resultMessage = "";
    var price = 0;

    if (area <= 3) {
        price = priceLessEqual3;
    } else if (area > 3 && area <= 8) {
        price = price3To8;
    } else if (area > 8 && area <= 15) {
        price = price8To15;
    } else if (area > 15 && area <= 21) {
        price = price15To21;
    } else if (area > 21 && area <= 30) {
        price = price21To30;
    } else {
        // For area > 30, update the price dynamically
        price = area;
        document.getElementById('input_price_greater_30').value = price.toFixed(2); // Update the price for >30
    }

    resultMessage = `الناتج: ${area.toFixed(2)}. السعر: ${price.toFixed(2)}`;

    // Display the result
    document.getElementById('comparison_result').innerHTML = resultMessage;
}


        // Initialize the equation display on page load
        calculateEquation();
    </script>
@endsection
