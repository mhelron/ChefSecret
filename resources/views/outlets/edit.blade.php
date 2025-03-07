@extends('layouts.app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0" style="padding-top: 35px;">Edit Category</h1>
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
                    <a href="{{ route('categories.index') }}" class="btn btn-danger">Back</a>
                </div>

                <!-- Add User Form -->
                <div class="card">
                    <div class="card-body form-container">
                    <form action="{{url('categories/update-category/'.$key)}}" method="POST">
                            @csrf
                            @method('PUT')
                    

                                <!-- First Name -->
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label>Category Name<span class="text-danger"> *</span></label>
                                        <input type="text" name="category" value="{{ old('category', $editdata['category']) }}" class="form-control" placeholder="Enter category name">
                                        @error('category')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Last Name -->
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label>Description <span class="text-danger"> *</span></label>
                                        <textarea name="desc" id="desc" class="form-control">{{ old('desc', $editdata['desc']) }}</textarea>
                                        @error('desc')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Memory -->
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label>Status <span class="text-danger"> *</span></label>
                                        <select name="status" class="form-control">
                                            <option value="Active" {{ old('status', $editdata['status']) == 'Active' ? 'selected' : '' }}>Active</option>
                                            <option value="Inactive" {{ old('status', $editdata['status']) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        @error('status')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                            <!-- Submit button -->
                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-primary float-end">Update Category</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection