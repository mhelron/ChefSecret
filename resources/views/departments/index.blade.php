@extends('layouts.app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0">Departments</h1>
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
                    <a href="{{ route('departments.add') }}" class="btn btn-primary mb-2 float-end">Add</a>
                </div>

                <!-- Users Table -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">

                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Department</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Options</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php $i = 1; @endphp
                                    @forelse ($departments as $key => $item)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $item['department'] }}</td>
                                        <td>{{ $item['desc'] }}</td>
                                        <td>{{ $item['status'] }}</td>

                                        <td>
                                            <div class="d-flex">
                                                <a href="{{ url('/departments/edit-department/' . $key) }}" class="btn btn-sm btn-success me-2">Edit</a>
                                                <a href="{{ url('/departments/delete-department/    ' . $key) }}" class="btn btn-sm btn-secondary">Archive</a>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7">No Records Found</td>
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