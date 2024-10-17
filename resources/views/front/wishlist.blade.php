@extends('layouts.client')
@section('content_client')
    <style>

    </style>
    <h2>قائمة المفضلة</h2>
    <div class="container my-5">
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <!-- Card 1 -->
            @foreach ($products as $item)
                <div class="col">
                    <div class="card h-100">
                        <a href="{{ route('showProduct', $item->slug) }}" style="text-decoration:none">
                            <img src="{{ asset('uploads/' . $item->image) }}" class="card-img-top" alt="Product Image">
                        </a>
                        <div class="card-body text-center">
                            <a href="{{ route('showProduct', $item->slug) }}" style="text-decoration:none">

                                <h5 class="card-title">{{ $item->name }}</h5>
                            </a>
                            <p class="card-text">السعر: {{ $item->price }}</p>
                            <p class="card-text">
                                <span class="text-warning">&#9733;&#9733;&#9733;&#9733;&#9734;</span>
                                (4 stars)
                            </p>
                        </div>

                    </div>
                </div>
            @endforeach

        </div>

    </div>
    {{ $products->links('front.paginate') }} 

   
    <!-- Pagination Links -->


    <!-- Card 2 -->
@endsection
