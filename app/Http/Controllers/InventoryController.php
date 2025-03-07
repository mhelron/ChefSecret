<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;
use Illuminate\Support\Facades\Log;

class InventoryController extends Controller
{
    protected $database, $categories, $inventory, $archived_inventory;

    public function __construct(Database $database){
        $this->database = $database;
        $this->categories = 'categories';
        $this->inventory = 'inventory';
        $this->archived_inventory = 'archived_inventory';
    }
    
    public function index(){
        $inventory = $this->database->getReference('inventory')->getValue();
        $inventory = is_array($inventory) ? $inventory : [];

        $categories = $this->database->getReference($this->categories)->getValue();
        $categories = is_array($categories) ? $categories : [];

        return view('inventory.index', compact('inventory', 'categories'));
    }

    public function getCategoryFields($id)
    {
        Log::info('Getting fields for category ID: ' . $id);
        
        try {
            // First try direct lookup by ID (if it's a key)
            $categoryData = $this->database->getReference($this->categories.'/'.$id)->getValue();
            
            if ($categoryData && isset($categoryData['custom_fields'])) {
                Log::info('Found category by direct ID lookup');
                return response()->json($categoryData['custom_fields']);
            }
            
            // If not found by direct ID, try lookup by category name
            $allCategories = $this->database->getReference($this->categories)->getValue();
            
            if (is_array($allCategories)) {
                foreach ($allCategories as $key => $category) {
                    if (isset($category['category']) && $category['category'] == $id) {
                        Log::info('Found category by name lookup. Key: ' . $key);
                        
                        if (isset($category['custom_fields'])) {
                            return response()->json($category['custom_fields']);
                        }
                        break;
                    }
                }
            }
            
            Log::info('No custom fields found for category: ' . $id);
            return response()->json([]);
        } catch (\Exception $e) {
            Log::error('Error in getCategoryFields: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function create(){
        $categories = $this->database->getReference($this->categories)->getValue();
        $categories = is_array($categories) ? array_map(fn($category) => $category['category'], $categories) : [];

        return view('inventory.create', compact( 'categories'));
    }

    public function store(Request $request)
    {
        // Basic validation for the category
        $request->validate([
            'item_name' => 'required|string',
            'category' => 'required|string',
        ]);

        try {
            // Get the category ID for reference
            $categoryId = null;
            $categoryKey = null;
            $allCategories = $this->database->getReference($this->categories)->getValue();
            
            if (is_array($allCategories)) {
                foreach ($allCategories as $key => $category) {
                    if (isset($category['category']) && $category['category'] == $request->category) {
                        $categoryKey = $key;
                        break;
                    }
                }
            }
            
            // Collect custom fields data
            $customFieldsData = [];
            if ($request->has('custom_fields') && is_array($request->custom_fields)) {
                foreach ($request->custom_fields as $fieldName => $value) {
                    // Store the field value
                    $customFieldsData[$fieldName] = $value;
                }
            }
            
            if ($request->hasFile('custom_fields_files')) {
                foreach ($request->file('custom_fields_files') as $fieldName => $file) {
                    Log::info('File was uploaded for field ' . $fieldName . ' but not processed in this implementation');
                    
                    $path = $file->store('uploads/inventory');
                    $customFieldsData[$fieldName] = [
                    'path' => $path,
                    'original_name' => $file->getClientOriginalName()
                    ];
                }
            }
            
            // Prepare data for storage
            $inventoryData = [
                'item_name' => $request->item_name,
                'category' => $request->category,
                'category_key' => $categoryKey,
                'custom_fields' => $customFieldsData,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'status' => 'Active'
            ];
            
            // Store in Firebase
            $newInventoryRef = $this->database->getReference($this->inventory)->push($inventoryData);
            
            if ($newInventoryRef) {
                Log::info('Successfully added inventory item: ' . $newInventoryRef->getKey());
                return redirect()->route('inventory.index')->with('status', 'Inventory item added successfully');
            } else {
                Log::error('Failed to add inventory item');
                return redirect()->route('inventory.create')->with('error', 'Failed to add inventory item');
            }
        } catch (\Exception $e) {
            Log::error('Error in inventory store: ' . $e->getMessage());
            return redirect()->route('inventory.create')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            // Get the inventory item from the inventory reference, not categories
            $inventoryItem = $this->database->getReference($this->inventory)->getChild($id)->getValue();
            
            if (!$inventoryItem) {
                return redirect()->route('inventory.index')->with('error', 'Inventory item not found');
            }
            
            // Get categories for the dropdown
            $categoriesData = $this->database->getReference($this->categories)->getValue();
            $categories = is_array($categoriesData) ? array_map(fn($category) => $category['category'], $categoriesData) : [];
            
            return view('inventory.edit', compact('inventoryItem', 'categories', 'id'));
        } catch (\Exception $e) {
            Log::error('Error in inventory edit: ' . $e->getMessage());
            return redirect()->route('inventory.index')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified inventory item in storage.
     */
    public function update(Request $request, $id)
    {
        // Basic validation for the category
        $request->validate([
            'category' => 'required|string',
        ]);

        try {
            // Get the existing inventory item
            $inventoryItem = $this->database->getReference($this->inventory.'/'.$id)->getValue();
            
            if (!$inventoryItem) {
                return redirect()->route('inventory.index')->with('error', 'Inventory item not found');
            }
            
            // Get the category ID for reference
            $categoryKey = null;
            $allCategories = $this->database->getReference($this->categories)->getValue();
            
            if (is_array($allCategories)) {
                foreach ($allCategories as $catKey => $category) {
                    if (isset($category['category']) && $category['category'] == $request->category) {
                        $categoryKey = $catKey;
                        break;
                    }
                }
            }
            
            // Start with existing custom fields and update with new values
            $customFieldsData = $inventoryItem['custom_fields'] ?? [];
            
            // Update with new text field values
            if ($request->has('custom_fields') && is_array($request->custom_fields)) {
                foreach ($request->custom_fields as $fieldName => $value) {
                    // Update the field value
                    $customFieldsData[$fieldName] = $value;
                }
            }
            
            // Handle file uploads if any
            if ($request->hasFile('custom_fields_files')) {
                foreach ($request->file('custom_fields_files') as $fieldName => $file) {
                    // Here you would process file uploads
                    // This would involve storing files somewhere and saving references
                    // For now, we'll just log that files were received
                    Log::info('File was uploaded for field ' . $fieldName . ' but not processed in this implementation');
                    
                    // In a real implementation, you'd store the file and update the field reference
                    $path = $file->store('uploads/inventory');
                    $customFieldsData[$fieldName] = [
                    'path' => $path,
                    'original_name' => $file->getClientOriginalName()
                    ];
                }
            }
            
            // Keep track of existing images if they weren't replaced
            if ($request->has('existing_images') && is_array($request->existing_images)) {
                foreach ($request->existing_images as $fieldName => $jsonValue) {
                    // Only keep if no new file was uploaded
                    if (!$request->hasFile('custom_fields_files.'.$fieldName)) {
                        $customFieldsData[$fieldName] = json_decode($jsonValue, true);
                    }
                }
            }
            
            // Prepare data for update
            $inventoryData = [
                'category' => $request->category,
                'category_key' => $categoryKey,
                'custom_fields' => $customFieldsData,
                'updated_at' => date('Y-m-d H:i:s'),
                'status' => $inventoryItem['status'] ?? 'Active'
            ];
            
            // Preserve the created_at date
            if (isset($inventoryItem['created_at'])) {
                $inventoryData['created_at'] = $inventoryItem['created_at'];
            }
            
            // Update in Firebase
            $this->database->getReference($this->inventory.'/'.$id)->update($inventoryData);
            
            Log::info('Successfully updated inventory item: ' . $id);
            return redirect()->route('inventory.index')->with('status', 'Inventory item updated successfully');
        } catch (\Exception $e) {
            Log::error('Error in inventory update: ' . $e->getMessage());
            return redirect()->route('inventory.edit', $id)->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function archive($id){
        $key = $id;

        $inventory_data = $this->database->getReference($this->inventory.'/'.$key)->getValue();

        $archive_data = $this->database->getReference($this->archived_inventory.'/'.$key)->set($inventory_data);

        $del_data = $this->database->getReference($this->inventory.'/'.$key)->remove();

        if ($del_data && $archive_data) {
            return redirect('inventory')->with('status', 'Item Archived Successfully');
        } else {
            return redirect('inventory')->with('status', 'Item Not Archived');
        }
    }
}
