@extends('layouts.app')

@section('content')
    <div class="mb-4">
        <h2 class="text-xl font-semibold">Edit Todo</h2>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ route('todos.update', $todo) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title:</label>
                <input type="text" name="title" id="title" value="{{ old('title', $todo->title) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('title') border-red-500 @enderror" required>
                @error('title')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
                <textarea name="description" id="description" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('description') border-red-500 @enderror">{{ old('description', $todo->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="flex items-center">
                    <input type="checkbox" name="completed" value="1" {{ $todo->completed ? 'checked' : '' }} class="form-checkbox h-5 w-5 text-blue-600">
                    <span class="ml-2 text-gray-700">Completed</span>
                </label>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Update Todo
                </button>
                <a href="{{ route('todos.index') }}" class="text-gray-500 hover:text-gray-700">Cancel</a>
            </div>
        </form>
    </div>
@endsection