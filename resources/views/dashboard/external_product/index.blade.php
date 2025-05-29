@extends('layouts.master')
@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <style>
        .status-toggle {
            position: relative;
            display: inline-block;
        }

        .status-switch {
            display: none;
        }

        .status-label {
            display: block;
            width: 60px;
            height: 15px;
            background-color: #e74c3c;
            border-radius: 34px;
            position: relative;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .status-label .on,
        .status-label .off {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            color: white;
            font-size: 12px;
            font-weight: bold;
        }

        .status-label .on {
            left: 10px;
            display: none;
        }

        .status-label .off {
            right: 10px;
        }

        .status-switch:checked+.status-label {
            background-color: #2ecc71;
        }

        .status-switch:checked+.status-label .on {
            display: block;
        }

        .status-switch:checked+.status-label .off {
            display: none;
        }

        .status-label:after {
            content: '';
            position: absolute;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: white;
            top: 3px;
            left: 1px;
            transition: transform 0.3s;
        }

        .status-switch:checked+.status-label:after {
            transform: translateX(46px);
        }
    </style>
@endsection
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('المنتجات الخارجية') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a>
                                </li>

                                <li class="breadcrumb-item active">{{ __('المنتجات الخارجية') }}
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>

            </div>
            <div class="content-body">
                <!-- DOM - jQuery events table -->

                <!-- Row created callback -->
                <!-- File export table -->
                <section id="file-export">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">

                                <div class="card-content collapse show">
                                    <div class="card-body card-dashboard">
                                        @include('dashboard.inc.alerts')


                                        @if (session('success'))
                                            <div class="alert alert-success">{{ session('success') }}</div>
                                        @endif

                                        <table class="table table-bordered table-striped">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>#</th>
                                                    <th>الاسم</th>
                                                    <th>كود المنتج</th>
                                                    <th>الكمية المتاحة </th>
                                                    <th>السعر</th>

                                                    <th> الحالة</th>
                                                    <th> مشاهدة</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($products as $product)
                                                    <tr>
                                                        <td>{{ $product['id'] }}</td>
                                                        <td>{{ $product['name'] }}</td>
                                                        <td>{{ $product['default_code'] ?? '-' }}</td>
                                                        <td>{{$product['net_available_qty']}}</td>
                                                        <td>{{$product['price']}}</td>

                                                        <td>
                                                            <div class="status-toggle">
                                                                <input type="checkbox" class="status-switch"
                                                                    id="toggle-{{ $product['id'] }}"
                                                                    data-id="{{ $product['id'] }}"
                                                                    {{ $product['is_active'] ? 'checked' : '' }}>
                                                                <label for="toggle-{{ $product['id'] }}"
                                                                    class="status-label">

                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a class="btn btn-success"
                                                                href="{{ route('external-products.show', $product['id']) }}"><i
                                                                    class="ft-eye"></i> مشاهدة</a>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center">لا توجد منتجات.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>

                                        {{-- ✅ Pagination --}}
                                        <div class="d-flex justify-content-center">
                                            {{ $products->links('pagination::bootstrap-5') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        @endsection

        @section('script')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const toggles = document.querySelectorAll('.status-switch');

                    toggles.forEach(toggle => {
                        toggle.addEventListener('change', function() {
                            const productId = this.dataset.id;
                            const isActive = this.checked;

                            // Get the route URL using Laravel's named route
                            const url = "{{ route('external-products.toggle', ':id') }}".replace(':id',
                                productId);

                            fetch(url, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').content,
                                        'X-Requested-With': 'XMLHttpRequest'
                                    },
                                    body: JSON.stringify({
                                        is_active: isActive
                                    })
                                })
                                .then(response => {
                                    if (!response.ok) {
                                        // Revert if request fails
                                        toggle.checked = !isActive;
                                        throw new Error('Network response was not ok');
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    // Optional: Show toast notification
                                    Toastify({
                                        text: data.message || 'Status updated successfully',
                                        duration: 3000,
                                        close: true,
                                        gravity: "top",
                                        position: "right",
                                        backgroundColor: "#4CAF50",
                                    }).showToast();
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    Toastify({
                                        text: 'Failed to update status',
                                        duration: 3000,
                                        close: true,
                                        gravity: "top",
                                        position: "right",
                                        backgroundColor: "#F44336",
                                    }).showToast();
                                });
                        });
                    });
                });
            </script>
        @endsection
