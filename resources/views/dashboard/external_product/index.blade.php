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
 <style>
    .variant-item {
        background-color: #fff;
        margin-bottom: 8px !important;
    }

    .variant-checkbox {
        cursor: pointer;
    }

    .variant-item:hover {
        background-color: #f9f9f9;
    }

    #variant-list {
        padding-left: 0;
    }
</style>

<style>
    #floating-btn-container {
        position: fixed;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 9999;
        background-color: white;
        padding: 10px 20px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.15);
    }

    #group-import-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
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


                                        <form id="search-form" method="GET">
                                            <div class="row mb-2">
                                                <div class="col-md-4">
                                                    <input type="text" name="q" id="search-input"
                                                        class="form-control" placeholder="ابحث عن منتج...">
                                                </div>
                                            </div>
                                        </form>

                                        <div id="products-table-ajax">
                                            @include('dashboard.external_product.partials.table', [
                                                'products' => $products,
                                            ])
                                        </div>

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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let searchInput = document.getElementById('search-input');

            // عند الكتابة في خانة البحث
            searchInput.addEventListener('keyup', function() {
                let query = this.value;

                fetch(`{{ route('external-products.index') }}?q=${query}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('products-table-ajax').innerHTML = data;
                    })
                    .catch(error => {
                        console.error('Error fetching search results:', error);
                    });
            });

            // أيضًا يدعم التنقل بين الصفحات في البحث
            document.addEventListener('click', function(e) {
                if (e.target.closest('.pagination a')) {
                    e.preventDefault();
                    let url = e.target.closest('a').getAttribute('href');

                    fetch(url, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.text())
                        .then(data => {
                            document.getElementById('products-table-ajax').innerHTML = data;
                        });
                }
            });
        });
    </script>
    
@endsection
