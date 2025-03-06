@extends('layouts.app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0" style="padding-top: 35px;">Add Inventory</h1>
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
                    <a href="{{ route('inventory.index') }}" class="btn btn-danger">Back</a>
                </div>

                <!-- Add User Form -->
                <div class="card">
                    <div class="card-body form-container">
                        <form action="{{ route('inventory.store') }}" method="POST">
                            @csrf
                    

                                <!-- First Name -->
                                <div class="col-md-6 form-group mb-3">
                                    <label for="categories">Category</label>
                                    <select name="category" id="category_select" class="form-control">
                                        <option value="" disabled selected>Select an category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category }}" {{ old('categories') == $category ? 'selected' : '' }}>{{ $category }}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('categories'))
                                    <small class="text-danger">{{ $errors->first('categories') }}</small>
                                    @endif
                                </div>


                                <!-- Last Name -->
                                <div id="dynamic-fields-container" class="mt-4">
                                    <!-- Custom fields will be loaded here -->
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

<!-- JavaScript for handling dynamic fields -->
<script>
    document.getElementById('category_select').addEventListener('change', function() {
    const categoryId = this.value;
    const fieldsContainer = document.getElementById('dynamic-fields-container');
    
    // Clear previous fields
    fieldsContainer.innerHTML = '';
    
    if (categoryId) {
        // Show loading indicator
        fieldsContainer.innerHTML = '<div class="text-center"><p>Loading fields...</p></div>';
        
        // Fetch custom fields for selected category
        fetch(`/inventory/get-category-fields/${categoryId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(fields => {
                // Clear loading indicator
                fieldsContainer.innerHTML = '';
                
                if (fields && fields.length > 0) {                
                    // Create a container row for the grid
                    const rowDiv = document.createElement('div');
                    rowDiv.className = 'row';
                    fieldsContainer.appendChild(rowDiv);
                    
                    // Generate form inputs for each custom field
                    fields.forEach(field => {
                        // Create a column div for each field (6 columns = half width in Bootstrap's 12-column grid)
                        const colDiv = document.createElement('div');
                        colDiv.className = 'col-md-6';
                        rowDiv.appendChild(colDiv);
                        
                        const fieldGroup = document.createElement('div');
                        fieldGroup.className = 'form-group mb-3';
                        colDiv.appendChild(fieldGroup);
                        
                        const label = document.createElement('label');
                        label.innerHTML = field.name + (field.is_required ? '<span class="text-danger"> *</span>' : '');
                        fieldGroup.appendChild(label);
                        
                        let input;
                        
                        switch(field.type) {
                            case 'text':
                                input = document.createElement('input');
                                input.type = 'text';
                                input.className = 'form-control';
                                input.name = `custom_fields[${field.name}]`;
                                input.placeholder = `Enter ${field.name.toLowerCase()}`;
                                if (field.is_required) input.required = true;
                                break;
                                
                            case 'number':
                                input = document.createElement('input');
                                input.type = 'number';
                                input.className = 'form-control';
                                input.name = `custom_fields[${field.name}]`;
                                input.placeholder = `Enter ${field.name.toLowerCase()}`;
                                if (field.is_required) input.required = true;
                                break;
                                
                            case 'date':
                                input = document.createElement('input');
                                input.type = 'date';
                                input.className = 'form-control';
                                input.name = `custom_fields[${field.name}]`;
                                if (field.is_required) input.required = true;
                                break;
                                
                            case 'textarea':
                                input = document.createElement('textarea');
                                input.className = 'form-control';
                                input.name = `custom_fields[${field.name}]`;
                                input.placeholder = `Enter ${field.name.toLowerCase()}`;
                                input.rows = 3;
                                if (field.is_required) input.required = true;
                                break;
                                
                            case 'image':
                                input = document.createElement('input');
                                input.type = 'file';
                                input.className = 'form-control-file';
                                input.name = `custom_fields_files[${field.name}]`;
                                input.accept = 'image/*';
                                if (field.is_required) input.required = true;
                                break;
                            
                            default:
                                input = document.createElement('input');
                                input.type = 'text';
                                input.className = 'form-control';
                                input.name = `custom_fields[${field.name}]`;
                                input.placeholder = `Enter ${field.name.toLowerCase()}`;
                                if (field.is_required) input.required = true;
                        }
                        
                        fieldGroup.appendChild(input);
                        
                        // Add error display for this field
                        const errorSpan = document.createElement('small');
                        errorSpan.className = 'text-danger';
                        errorSpan.id = `error-${field.name.replace(/\s+/g, '-').toLowerCase()}`;
                        fieldGroup.appendChild(errorSpan);
                    });
                } else {
                    // No custom fields for this category
                    fieldsContainer.innerHTML = '<p class="text-info">This category does not have any custom fields defined.</p>';
                }
            })
            .catch(error => {
                console.error('Error fetching custom fields:', error);
                fieldsContainer.innerHTML = '<p class="text-danger">Error loading custom fields. Please try again.</p>';
            });
    }
});
</script>

@endsection