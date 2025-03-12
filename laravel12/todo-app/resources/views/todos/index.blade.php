@extends('layouts.app')

@section('content')
    <div class="mb-4 flex justify-between items-center">
        <h2 class="text-xl font-semibold">Todo List</h2>
        <a href="{{ route('todos.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
            Add New Todo
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        @if(count($todos) > 0)
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($todos as $todo)
                        <tr>
                            <td class="py-3 px-4 text-sm">{{ $todo->title }}</td>
                            <td class="py-3 px-4 text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $todo->completed ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $todo->completed ? 'Completed' : 'Pending' }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-sm">
                                <div class="flex space-x-2">
                                    <a href="{{ route('todos.show', $todo) }}" class="text-blue-500 hover:text-blue-700">View</a>
                                    <a href="{{ route('todos.edit', $todo) }}" class="text-indigo-500 hover:text-indigo-700">Edit</a>
                                    <form action="{{ route('todos.destroy', $todo) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="p-4 text-center text-gray-500">No todos found. Create one!</div>
        @endif
    </div>
@endsection