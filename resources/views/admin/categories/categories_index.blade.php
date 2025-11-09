@extends('layouts.admin-layout')

@section('content')
<div class="ml-0 md:ml-64 flex justify-center items-start min-h-screen py-8 px-4">
    <div class="w-full max-w-6xl">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                <div class="mb-4 sm:mb-0">
                    <h1 class="text-3xl font-bold text-gray-800">Manage Categories</h1>
                    <p class="text-gray-600 mt-2">View and manage all product categories</p>
                </div>
                <a href="{{ route('categories.create') }}" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg font-medium transition-colors">
                    <i class="fas fa-plus mr-2"></i>Add New Category
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- Centered Table Container -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($categories as $category)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $category->name }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-500 max-w-md">{{ Str::limit($category->description, 80) ?? 'No description' }}</div>
                            </td>
                           <td class="px-6 py-4 whitespace-nowrap">
    <form method="POST" action="{{ route('categories.toggleStatus', $category->id) }}">
        @csrf
        @method('PATCH')
        <button type="submit"
            class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full transition-colors duration-300
            {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
            {{ $category->is_active ? 'Active' : 'Inactive' }}
        </button>
    </form>
</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-4">
                                    <a href="{{ route('categories.edit', $category) }}" class="text-blue-600 hover:text-blue-900 transition-colors flex items-center">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </a>
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this category?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 transition-colors flex items-center">
                                            <i class="fas fa-trash mr-1"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center">
                                <div class="text-gray-500 mb-2">
                                    <i class="fas fa-inbox text-4xl mb-3"></i>
                                </div>
                                <p class="text-sm text-gray-500 mb-2">No categories found.</p>
                                <a href="{{ route('categories.create') }}" class="text-blue-600 hover:text-blue-900 font-medium">Create the first category</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination (if you have it) -->
        {{-- @if($categories->hasPages())
        <div class="mt-6">
            {{ $categories->links() }}
        </div>
        @endif --}}
    </div>
</div>
@endsection
