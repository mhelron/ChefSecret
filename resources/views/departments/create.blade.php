@extends('layouts.app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0" style="padding-top: 35px;">Add Department</h1>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-12">

                <div class="d-flex justify-content-end mb-2">
                    <a href="{{ route('departments.index') }}" class="btn btn-danger">Back</a>
                </div>

                <!-- Add User Form -->
                <div class="card">
                    <div class="card-body form-container">
                        <form action="{{ route('departments.store') }}" method="POST">
                            @csrf
                    

                                <!-- First Name -->
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label>Department Name<span class="text-danger"> *</span></label>
                                        <input type="text" name="department" value="{{ old('department') }}" class="form-control" placeholder="Enter department name">
                                        @error('department')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Last Name -->
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label>Description <span class="text-danger"> *</span></label>
                                        <textarea type="text" name="desc" value="{{ old('desc') }}" class="form-control" placeholder="Enter description"></textarea>
                                        @error('desc')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                            <!-- Submit button -->
                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-primary float-end">Add Department</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection