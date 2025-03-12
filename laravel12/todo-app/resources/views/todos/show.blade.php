@extends('layouts.app')

@section('content')
    <div class="mb-4 flex justify-between items-center">
        <h2 class="text-xl font-semibold">Todo Details</h2>
        <a href="{{ route('todos.index') }}" class="text-blue-500 hover:text-blue-700">Back to List</a>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="mb-4">
            <h3 class="text-lg font-medium text-gray-900">{{ $todo->title }}</h3>
            <p class="mt-2 text-gray-600">{{ $todo->description ?: 'No description provided.' }}</p>
        </div>
        
        <div class="mb-4">
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $todo->completed ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                {{ $todo->completed ? 'Completed' : 'Pending' }}
            </span>
        </div>
        
        <div class="mt-6 flex space-x-4">
            <a href="{{ route('todos.edit', $todo) }}" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded">Edit</a>
            
            <form action="{{ route('todos.destroy', $todo) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Are you sure you want to delete this item?')">
                    Delete
                </button>
            </form>
            
            <form action="{{ route('todos.update', $todo) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="title" value="{{ $todo->title }}">
                <input type="hidden" name="description" value="{{ $todo->description }}">
                <input type="hidden" name="completed" value="{{ $todo->completed ? '0' : '1' }}">
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                    Mark as {{ $todo->completed ? 'Pending' : 'Completed' }}
                </button>
            </form>
        </div>
    </div>
@endsection