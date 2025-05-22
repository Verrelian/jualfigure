@extends('layout.app')
@section('content')

    <div class="container mx-auto py-8 px-4">
        <div class="max-w-2xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold">Create New Post</h1>
                <a href="{{ route('posts.index') }}" class="text-blue-500 hover:underline">
                    ← Back to feed
                </a>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 mb-2">Title</label>
                        <input type="text" name="title" id="title" 
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               required>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 mb-2">Description</label>
                        <textarea name="description" id="description" rows="5"
                                  class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  required></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="image" class="block text-gray-700 mb-2">Image</label>
                        <input type="file" name="image" id="image"
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               accept="image/*">
                    </div>

                    <button type="submit" 
                            class="w-full bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Publish
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection