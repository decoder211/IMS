<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Display a listing of the categories
    public function index()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.categories.categories_index', compact('categories'));
    }

    // Show the form for creating a new category
    public function create()
    {
        return view('admin.categories.add_categories');
    }

    // Store a newly created category
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        Category::create([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully!');
    }

    // Display the specified category (optional)
    public function show(Category $category)
    {
        return view('admin.categories.categories_index', compact('category'));
    }

    // Show the form for editing the category
    public function edit(Category $category)
    {
        return view('admin.categories.edit_categories', compact('category'));
    }

    // Update the specified category
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $category->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully!');
    }

    // Remove the specified category
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully!');
    }
    public function toggleStatus($id)
{
    $category = Category::findOrFail($id);
    $category->is_active = !$category->is_active;
    $category->save();

    return redirect()->route('categories.index')->with('status', 'Category status updated!');
}
}
