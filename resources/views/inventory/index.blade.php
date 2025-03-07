@extends('layouts.app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0">Inventory</h1>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">

                <!-- Bootstrap Toast -->
                @if (session('status'))
                    <div class="toast-container position-fixed top-0 end-0 p-3">
                        <div class="toast text-bg-light border border-dark custom-toast-size" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="d-flex">
                                <div class="toast-body">
                                    {{ session('status') }}
                                </div>
                                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="d-flex justify-content-end">
                    <a href="{{ route('inventory.add') }}" class="btn btn-primary mb-2 float-end">Add</a>
                </div>

                <!-- Inventory Table -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Item</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Custom Fields</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php $i = 1; @endphp
                                    @forelse ($inventory as $key => $item)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $item['item_name'] ?? 'N/A' }}</td>
                                        <td>{{ $item['category'] ?? 'N/A' }}</td>
                                        <td>{{ $item['status'] ?? 'N/A' }}</td>
                                        <td>
                                            @if(isset($item['custom_fields']) && !empty($item['custom_fields']))
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#detailsModal{{ $key }}">
                                                    See Details
                                                </button>
                                                
                                                <!-- Modal for Custom Fields -->
                                                <div class="modal fade" id="detailsModal{{ $key }}" tabindex="-1" aria-labelledby="detailsModalLabel{{ $key }}" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="detailsModalLabel{{ $key }}">
                                                                    Custom Fields for {{ $item['category'] ?? 'Item' }}
                                                                </h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    @foreach($item['custom_fields'] as $fieldName => $fieldValue)
                                                                        <div class="col-md-6 mb-3">
                                                                            <div class="card">
                                                                                <div class="card-header">
                                                                                    <strong>{{ $fieldName }}</strong>
                                                                                </div>
                                                                                <div class="card-body">
                                                                                    @if(is_array($fieldValue) && isset($fieldValue['path']))
                                                                                        <!-- Display for image fields -->
                                                                                        <img src="{{ asset($fieldValue['path']) }}" alt="{{ $fieldValue['original_name'] ?? $fieldName }}" 
                                                                                             class="img-fluid mb-2" style="max-height: 200px;">
                                                                                        <p class="text-muted">{{ $fieldValue['original_name'] ?? '' }}</p>
                                                                                    @else
                                                                                        <!-- Display for regular fields -->
                                                                                        <p>{{ $fieldValue }}</p>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-muted">No custom fields</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="{{ url('/inventory/edit-inventory/' . $key) }}" class="btn btn-sm btn-success me-2">Edit</a>
                                                <a href="{{ url('/inventory/archive-inventory/' . $key) }}" class="btn btn-sm btn-secondary">Archive</a>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No Records Found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.Main content -->

@endsection