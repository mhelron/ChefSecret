@extends('layouts.app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0">Dashboard</h1>
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
                
            <div class="row mb-3">
        <!-- Column 1 -->
        <div class="col-lg-2 col-xs-6">
            <a href="#" class="card-link">
                <div class="card pencil card1 p-3 box-shadow">
                    <div class="row mb-2">
                        <div class="col-md-12 d-flex justify-content-md-end">
                            <i class="fa-solid fa-pencil icon-pencil"></i>
                        </div>
                    </div>
                    
                    <!-- Title (optional) -->
                    <h1 class="text-start">3</h1> 

                    <!-- Content in the Card -->
                    <div class="row d-flex align-items-lg-center justify-content-lg-between">
                        <div class="col-md-6">
                            <p class="text-secondary mt-2 fw-bold">Inventory</p> <i class="bi bi-box-seam"></i>
                        </div>
                        <div class="col-md-6 d-flex justify-content-md-end">
                            <i class="bx bx-right-arrow-alt fs-3"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Column 2 -->
        <div class="col-lg-2 col-xs-6">
            <a href="#" class="card-link">
                <div class="card pending card1 p-3 box-shadow">
                    <div class="row mb-2">
                        <div class="col-md-12 d-flex justify-content-md-end">
                            <i class="fa-solid fa-spinner icon-pending"></i>
                        </div>
                    </div>
                    
                    <!-- Title (optional) -->
                    <h1 class="text-start">0</h1>

                    <!-- Content in the Card -->
                    <div class="row d-flex align-items-lg-center justify-content-lg-between">
                        <div class="col-md-6">
                            <p class="text-secondary mt-2 fw-bold">Categories</p> <i class="bi bi-folder"></i>
                        </div>
                        <div class="col-md-6 d-flex justify-content-md-end">
                            <i class="bx bx-right-arrow-alt fs-3"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="row pt-3">
        <div class="col-lg-4 col-xs-6">
            <div class="card upcoming-events p-3 box-shadow fixed-height-card">
                <div class="row mb-2">
                    <div class="col-md-12 d-flex justify-content-md-end">
                        <i class="bx bx-calendar"></i>
                    </div>
                </div>
                <h1 class="text-start">Up coming List</h1> <!-- sample text --> 
                
                                    <div class="empty-card-content">
                        <p class="text-center text-muted">No upcoming List.</p>
                    </div>
                            </div>
        </div>

         <!-- Top 10 Packages Card -->
        <div class="col-lg-4 col-xs-6">
            <div class="card p-3 box-shadow fixed-height-card">
                <div class="row mb-2">
                    <div class="col-md-12 d-flex justify-content-md-end">
                        <i class="bx bx-trophy"></i>
                    </div>
                </div>
                <h1 class="text-start">List</h1> <!-- sample text -->

                                    <div class="list-group">
                                                  
                </div>
            </div>
         </div>                  
                <p>Dashboard wala pang laman</p>

        </div>
    </div>
</div>

@endsection