@extends('layouts.app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0" style="padding-top: 35px;">Edit Inventory</h1>
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

                <!-- Edit Inventory Form -->
                <div class="card">
                    <div class="card-body form-container">
                        <form action="{{ route('inventory.update', $id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Category Selection -->
                            <div class="col-md-6 form-group mb-3">
                                <label for="categories">Category</label>
                                <select name="category" id="category_select" class="form-control">
                                    <option value="" disabled>Select a category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category }}" {{ $inventoryItem['category'] == $category ? 'selected' : '' }}>{{ $category }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('category'))
                                <small class="text-danger">{{ $errors->first('category') }}</small>
                                @endif
                            </div>

                            <!-- Dynamic Custom Fields Container -->
                            <div id="dynamic-fields-container" class="mt-4">
                                <!-- Custom fields will be loaded here -->
                            </div>

                            <!-- Submit button -->
                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-primary float-end">Update Item</button>
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
    // Store the existing custom field values
    const existingValues = @json($inventoryItem['custom_fields'] ?? []);
    
    // Function to load fields when page loads and on category change
    function loadCategoryFields(categoryId) {
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
                            // Create a column div for each field
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
                            const fieldValue = existingValues[field.name] || '';
                            
                            switch(field.type) {
                                case 'text':
                                    input = document.createElement('input');
                                    input.type = 'text';
                                    input.className = 'form-control';
                                    input.name = `custom_fields[${field.name}]`;
                                    input.placeholder = `Enter ${field.name.toLowerCase()}`;
                                    input.value = fieldValue;
                                    if (field.is_required) input.required = true;
                                    break;
                                    
                                case 'number':
                                    input = document.createElement('input');
                                    input.type = 'number';
                                    input.className = 'form-control';
                                    input.name = `custom_fields[${field.name}]`;
                                    input.placeholder = `Enter ${field.name.toLowerCase()}`;
                                    input.value = fieldValue;
                                    if (field.is_required) input.required = true;
                                    break;
                                    
                                case 'date':
                                    input = document.createElement('input');
                                    input.type = 'date';
                                    input.className = 'form-control';
                                    input.name = `custom_fields[${field.name}]`;
                                    input.value = fieldValue;
                                    if (field.is_required) input.required = true;
                                    break;
                                    
                                case 'textarea':
                                    input = document.createElement('textarea');
                                    input.className = 'form-control';
                                    input.name = `custom_fields[${field.name}]`;
                                    input.placeholder = `Enter ${field.name.toLowerCase()}`;
                                    input.rows = 3;
                                    input.textContent = fieldValue;
                                    if (field.is_required) input.required = true;
                                    break;
                                    
                                case 'image':
                                    // Container for image field
                                    const imageContainer = document.createElement('div');
                                    
                                    // Show existing image if available
                                    if (fieldValue && typeof fieldValue === 'object' && fieldValue.path) {
                                        const currentImage = document.createElement('div');
                                        currentImage.className = 'mb-2';
                                        
                                        const img = document.createElement('img');
                                        img.src = fieldValue.path;
                                        img.alt = fieldValue.original_name || 'Current image';
                                        img.className = 'img-thumbnail';
                                        img.style.maxHeight = '150px';
                                        
                                        const imageName = document.createElement('p');
                                        imageName.className = 'text-muted small';
                                        imageName.textContent = fieldValue.original_name || '';
                                        
                                        currentImage.appendChild(img);
                                        currentImage.appendChild(imageName);
                                        imageContainer.appendChild(currentImage);
                                        
                                        // Hidden input to keep track of existing image
                                        const hiddenInput = document.createElement('input');
                                        hiddenInput.type = 'hidden';
                                        hiddenInput.name = `existing_images[${field.name}]`;
                                        hiddenInput.value = JSON.stringify(fieldValue);
                                        imageContainer.appendChild(hiddenInput);
                                    }
                                    
                                    // File input for new image
                                    input = document.createElement('input');
                                    input.type = 'file';
                                    input.className = 'form-control-file';
                                    input.name = `custom_fields_files[${field.name}]`;
                                    input.accept = 'image/*';
                                    
                                    // Label for new image
                                    const newImageLabel = document.createElement('small');
                                    newImageLabel.className = 'text-muted';
                                    newImageLabel.textContent = ' Upload new image (leave empty to keep current)';
                                    
                                    imageContainer.appendChild(input);
                                    imageContainer.appendChild(newImageLabel);
                                    
                                    fieldGroup.appendChild(imageContainer);
                                    break;
                                
                                default:
                                    input = document.createElement('input');
                                    input.type = 'text';
                                    input.className = 'form-control';
                                    input.name = `custom_fields[${field.name}]`;
                                    input.placeholder = `Enter ${field.name.toLowerCase()}`;
                                    input.value = fieldValue;
                                    if (field.is_required) input.required = true;
                            }
                            
                            // Don't add input again if it was already added (for image fields)
                            if (field.type !== 'image') {
                                fieldGroup.appendChild(input);
                            }
                            
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
    }

    // Load fields when category changes
    document.getElementById('category_select').addEventListener('change', function() {
        loadCategoryFields(this.value);
    });
    
    // Load fields when page loads with the initial category value
    document.addEventListener('DOMContentLoaded', function() {
        const categorySelect = document.getElementById('category_select');
        if (categorySelect.value) {
            loadCategoryFields(categorySelect.value);
        }
    });
</script>

@endsection