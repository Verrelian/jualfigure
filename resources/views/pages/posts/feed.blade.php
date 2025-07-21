@extends('layout.app')

@section('content')

    <div class="container mx-auto p-4">
    <div class="bg-white border-b border-gray-200 backdrop-blur-sm bg-white/95">
        <div class="container mx-auto max-w-4xl px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                        <span class="text-white font-bold text-lg">R</span>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">MoFeed</h1>
                        <p class="text-sm text-gray-500">Discover amazing content</p>
                    </div>
                </div>

                <button
                    onclick="document.getElementById('modal-create').classList.remove('hidden')"
                    class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-2.5 rounded-full font-medium transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Create Post</span>
                </button>
            </div>
        </div>
    </div>

    {{-- MODAL CREATE POST - RESPONSIVE DESIGN --}}
    <div id="modal-create" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl lg:max-w-3xl xl:max-w-4xl mx-auto transform transition-all max-h-[90vh] overflow-y-auto">
            {{-- Header --}}
            <div class="flex justify-between items-center p-6 lg:p-8 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-purple-50">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl lg:text-2xl font-bold text-gray-900">Create New Post</h2>
                        <p class="text-sm text-gray-600">Share your amazing content with the community</p>
                    </div>
                </div>
                <button
                    onclick="document.getElementById('modal-create').classList.add('hidden')"
                    class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 p-2 rounded-full transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            {{-- Form Content --}}
            <div class="p-6 lg:p-8">
                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    {{-- Grid Layout for Desktop --}}
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        {{-- Left Column --}}
                        <div class="space-y-6">
                            {{-- Title --}}
                            <div>
                                <label for="title" class="block text-sm font-semibold text-gray-700 mb-3">
                                    <span class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                        <span>Post Title</span>
                                    </span>
                                </label>
                                <input type="text" name="title" id="title"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition-all text-lg"
                                       placeholder="Enter an engaging title..." required>
                            </div>

                            {{-- Description --}}
                            <div>
                                <label for="description" class="block text-sm font-semibold text-gray-700 mb-3">
                                    <span class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <span>Description</span>
                                    </span>
                                </label>
                                <textarea name="description" id="description" rows="6"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm resize-none transition-all"
                                          placeholder="Tell your story, share your experience, or describe your collection..." required></textarea>
                                <div class="mt-2 text-sm text-gray-500">
                                    <span id="char-count">0</span> characters
                                </div>
                            </div>
                        </div>

                        {{-- Right Column --}}
                        <div class="space-y-6">
                            {{-- Upload Section --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">
                                    <span class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span>Upload Images</span>
                                    </span>
                                </label>

                                {{-- Drag and Drop Area --}}
                                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 hover:border-blue-400 transition-colors bg-gray-50 hover:bg-blue-50">
                                    <div class="text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                        <div class="mt-4">
                                            <label for="images" class="cursor-pointer">
                                                <span class="mt-2 block text-sm font-medium text-gray-900">
                                                    Click to upload or drag and drop
                                                </span>
                                                <span class="mt-1 block text-sm text-gray-500">
                                                    PNG, JPG, JPEG up to 2MB each
                                                </span>
                                            </label>
                                            <input type="file" name="images[]" id="images" multiple accept="image/*"
                                                   class="sr-only" />
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-2 text-sm text-gray-500">
                                    <span class="flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>You can select multiple images at once</span>
                                    </span>
                                </p>
                            </div>

                            {{-- Preview Area --}}
                            <div id="preview-container" class="hidden">
                                <h4 class="text-sm font-semibold text-gray-700 mb-3">Preview</h4>
                                <div id="preview-images" class="grid grid-cols-2 gap-2 max-h-60 overflow-y-auto"></div>
                            </div>

                            {{-- Post Settings --}}
                            <div class="bg-gray-50 p-4 rounded-xl">
                                <h4 class="text-sm font-semibold text-gray-700 mb-3">Post Settings</h4>
                                <div class="space-y-3">
                                    <label class="flex items-center space-x-3">
                                        <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span class="text-sm text-gray-600">Allow comments</span>
                                    </label>
                                    <label class="flex items-center space-x-3">
                                        <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span class="text-sm text-gray-600">Public post</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex flex-col sm:flex-row justify-between items-center pt-6 border-t border-gray-200 space-y-3 sm:space-y-0">
                        <button type="button"
                                onclick="document.getElementById('modal-create').classList.add('hidden')"
                                class="w-full sm:w-auto px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-full transition-colors">
                            Cancel
                        </button>
                        <div class="flex space-x-3">
                            <button type="button"
                                    class="px-6 py-3 bg-white hover:bg-gray-50 text-gray-700 font-medium rounded-full border border-gray-300 transition-colors">
                                Save Draft
                            </button>
                            <button type="submit"
                                    class="px-8 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium rounded-full transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                Publish Post
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container mx-auto max-w-4xl px-4 py-8">
        {{-- Success/Error Messages --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Sukses!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @if (session('info'))
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Info!</strong>
                <span class="block sm:inline">{{ session('info') }}</span>
            </div>
        @endif

        @if($posts->count() > 0)
            <div class="space-y-8">
                @foreach($posts as $post)
                    <article class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
                        <div class="p-6 pb-4">
                            <div class="flex items-center space-x-3 mb-4">
                                <a href="{{ route('profile.show', $post->buyer->buyer_id) }}" class="flex items-center space-x-3">
                                <div class="relative">
                                    <img src="{{ $post->buyer->avatar_url }}"
                                         class="h-12 w-12 rounded-full ring-2 ring-gray-100"
                                         alt="{{ $post->buyer->username ?? 'Unknown' }} Avatar">
                                    <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-400 rounded-full border-2 border-white"></div>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900">{{ $post->buyer->username ?? 'Unknown User' }}</h3>
                                    <p class="text-sm text-gray-500 flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>{{ $post->created_at->diffForHumans() }}</span>
                                    </p>
                                </div>
                                </a>
                                <div class="flex items-center space-x-2">
                                    <button class="text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-6">
                                <h2 class="text-xl font-bold text-gray-900 mb-3 leading-tight">{{ $post->title }}</h2>
                                <p class="text-gray-600 leading-relaxed">{{ Str::limit($post->description, 300) }}</p>
                            </div>
                        </div>

                        @if($post->images->count())
                            <div class="px-6 pb-6">
                                @if($post->images->count() == 1)
                                    {{-- Single Image: Full Width --}}
                                    <div class="rounded-2xl overflow-hidden bg-gray-100 max-w-2xl mx-auto">
                                        <img src="{{ asset('storage/' . $post->images->first()->image) }}"
                                            class="w-full h-auto object-contain max-h-[600px]"
                                            alt="Post Image">
                                    </div>
                                @elseif($post->images->count() == 2)
                                    {{-- Two Images: Side by Side --}}
                                    <div class="grid grid-cols-2 gap-2 max-w-3xl mx-auto">
                                        @foreach($post->images as $img)
                                            <div class="rounded-xl overflow-hidden bg-gray-100 aspect-[4/3]">
                                                <img src="{{ asset('storage/' . $img->image) }}"
                                                    class="w-full h-full object-cover hover:scale-105 transition-transform duration-300 cursor-pointer"
                                                    alt="Post Image"
                                                    onclick="openImageModal('{{ asset('storage/' . $img->image) }}')">
                                            </div>
                                        @endforeach
                                    </div>
                                @elseif($post->images->count() == 3)
                                    {{-- Three Images: One large, two small --}}
                                    <div class="grid grid-cols-2 gap-2 max-w-3xl mx-auto">
                                        <div class="rounded-xl overflow-hidden bg-gray-100 aspect-[4/3]">
                                            <img src="{{ asset('storage/' . $post->images->first()->image) }}"
                                                class="w-full h-full object-cover hover:scale-105 transition-transform duration-300 cursor-pointer"
                                                alt="Post Image"
                                                onclick="openImageModal('{{ asset('storage/' . $post->images->first()->image) }}')">
                                        </div>
                                        <div class="grid grid-rows-2 gap-2">
                                            @foreach($post->images->skip(1) as $img)
                                                <div class="rounded-xl overflow-hidden bg-gray-100 aspect-[4/3]">
                                                    <img src="{{ asset('storage/' . $img->image) }}"
                                                        class="w-full h-full object-cover hover:scale-105 transition-transform duration-300 cursor-pointer"
                                                        alt="Post Image"
                                                        onclick="openImageModal('{{ asset('storage/' . $img->image) }}')">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @elseif($post->images->count() == 4)
                                    {{-- Four Images: 2x2 Grid --}}
                                    <div class="grid grid-cols-2 gap-2 max-w-2xl mx-auto">
                                        @foreach($post->images as $img)
                                            <div class="rounded-xl overflow-hidden bg-gray-100 aspect-square">
                                                <img src="{{ asset('storage/' . $img->image) }}"
                                                    class="w-full h-full object-cover hover:scale-105 transition-transform duration-300 cursor-pointer"
                                                    alt="Post Image"
                                                    onclick="openImageModal('{{ asset('storage/' . $img->image) }}')">
                                            </div>
                                        @endforeach
                                    </div>
                                @elseif($post->images->count() >= 5)
                                    {{-- Five or More Images: Complex Grid --}}
                                    <div class="grid grid-cols-2 gap-2 max-w-3xl mx-auto">
                                        {{-- First two images full height --}}
                                        @foreach($post->images->take(2) as $img)
                                            <div class="rounded-xl overflow-hidden bg-gray-100 aspect-[4/3]">
                                                <img src="{{ asset('storage/' . $img->image) }}"
                                                    class="w-full h-full object-cover hover:scale-105 transition-transform duration-300 cursor-pointer"
                                                    alt="Post Image"
                                                    onclick="openImageModal('{{ asset('storage/' . $img->image) }}')">
                                            </div>
                                        @endforeach

                                        {{-- Remaining images in smaller grid --}}
                                        @if($post->images->count() > 2)
                                            <div class="col-span-2 grid grid-cols-3 gap-2 mt-2">
                                                @foreach($post->images->skip(2)->take(3) as $index => $img)
                                                    <div class="rounded-xl overflow-hidden bg-gray-100 aspect-square relative">
                                                        <img src="{{ asset('storage/' . $img->image) }}"
                                                            class="w-full h-full object-cover hover:scale-105 transition-transform duration-300 cursor-pointer"
                                                            alt="Post Image"
                                                            onclick="openImageModal('{{ asset('storage/' . $img->image) }}')">

                                                        {{-- Show +X overlay for last image if more than 5 images --}}
                                                        @if($index == 2 && $post->images->count() > 5)
                                                            <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center rounded-xl cursor-pointer hover:bg-opacity-70 transition-colors"
                                                                onclick="openImageModal('{{ asset('storage/' . $img->image) }}')">
                                                                <span class="text-white text-2xl font-bold">+{{ $post->images->count() - 5 }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endif

                        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center space-x-6">
                                <form action="{{ route('posts.like', ['post' => $post->id]) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="flex items-center space-x-2 text-gray-600 hover:text-red-500 transition-colors group">
                                            <div class="p-2 rounded-full group-hover:bg-red-50 transition-colors">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                                </svg>
                                            </div>
                                            <span class="font-medium">{{ $post->likes_count }}</span>
                                        </button>
                                    </form>

                                    {{-- Modified Comment Button with Popup --}}
                                    <button onclick="openCommentModal({{ $post->id }})" class="flex items-center space-x-2 text-gray-600 hover:text-blue-500 transition-colors group">
                                        <div class="p-2 rounded-full group-hover:bg-blue-50 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                            </svg>
                                        </div>
                                        <span class="font-medium">{{ $post->comments_count }} Comments</span>
                                    </button>
                                </div>

                                <button class="text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                                    </svg>
                                </button>
                            </div>

                            {{-- Comment Modal Popup --}}
                            <div id="comment-modal-{{ $post->id }}" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
                                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl h-[600px] flex flex-col">
                                    {{-- Modal Header --}}
                                    <div class="flex items-center justify-between p-6 border-b border-gray-200">
                                        <h3 class="text-lg font-bold text-gray-900">Comments</h3>
                                        <button onclick="closeCommentModal({{ $post->id }})" class="text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>

                                    {{-- Comments List - Scrollable --}}
                                    <div class="flex-1 overflow-y-auto px-6 py-4 custom-scrollbar">
                                        @if($post->comments->count() > 0)
                                            <div class="space-y-4">
                                                @foreach($post->comments as $comment)
                                                    <div class="comment-thread">
                                                        {{-- Parent Comment --}}
                                                        <div class="flex space-x-3 group">
                                                                @php
                                                                    $isOwner = $comment->buyer->id === $post->buyer->id;
                                                                    $isMyComment = $comment->buyer->id === auth()->id();
                                                                @endphp

                                                                <img
                                                                    src="{{ $comment->buyer->avatar_url }}"
                                                                    class="h-10 w-10 rounded-full flex-shrink-0
                                                                        @if($isMyComment)
                                                                            ring-2 ring-blue-500
                                                                        @elseif($isOwner)
                                                                            ring-2 ring-yellow-500
                                                                        @else
                                                                            ring-1 ring-gray-300
                                                                        @endif
                                                                    "
                                                                    alt="Commenter Avatar">
                                                            <div class="flex-1">
                                                                <div class="bg-gray-100 rounded-2xl px-4 py-3 group-hover:bg-gray-150 transition-colors">
                                                                    <p class="font-semibold text-gray-900 text-sm mb-1">{{ $comment->buyer->username ?? 'Unknown Commenter' }}</p>
                                                                    <p class="text-gray-800 text-sm leading-relaxed">{{ $comment->comment }}</p>
                                                                </div>
                                                                <div class="flex items-center space-x-4 mt-2 ml-4">
                                                                    <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                                                    <button class="text-xs text-gray-500 hover:text-blue-600 font-medium">Like</button>
                                                                    <button onclick="toggleReplyForm({{ $comment->id }})" class="text-xs text-gray-500 hover:text-blue-600 font-medium">Reply</button>
                                                                    @if($comment->user_id === session('user_id'))
                                                                        <form action="{{ route('posts.comment.delete', $comment->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus comment ini?')">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="text-xs text-red-500 hover:text-red-600 font-medium">Delete</button>
                                                                        </form>
                                                                    @endif
                                                                </div>

                                                                {{-- Reply Form (Hidden by default) --}}
                                                                <div id="reply-form-{{ $comment->id }}" class="hidden mt-3 ml-4">
                                                                    <form action="{{ route('posts.reply', $comment->id) }}" method="POST">
                                                                        @csrf
                                                                        <div class="flex space-x-2">
                                                                            <img src="{{ session('buyer_avatar_url') }}" class="h-8 w-8 rounded-full flex-shrink-0" alt="Your Avatar">
                                                                            <div class="flex-1 flex space-x-2">
                                                                                <input type="text"
                                                                                    name="comment"
                                                                                    placeholder="Write a reply..."
                                                                                    class="flex-1 px-3 py-2 bg-white border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-sm"
                                                                                    required>
                                                                                <button type="submit"
                                                                                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-full font-medium transition-colors text-sm">
                                                                                    Reply
                                                                                </button>
                                                                                <button type="button" onclick="toggleReplyForm({{ $comment->id }})"
                                                                                        class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-full font-medium transition-colors text-sm">
                                                                                    Cancel
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>

                                                                {{-- Replies --}}
                                                                @if($comment->replies->count() > 0)
                                                                    <div class="mt-4 space-y-3">
                                                                        @foreach($comment->replies as $reply)
                                                                            <div class="flex space-x-3 ml-6 group">
                                                                                <img src="{{ $reply->buyer->avatar_url }}" class="h-8 w-8 rounded-full flex-shrink-0" alt="Replier Avatar">
                                                                                <div class="flex-1">
                                                                                    <div class="bg-gray-50 rounded-2xl px-3 py-2 group-hover:bg-gray-100 transition-colors">
                                                                                        <p class="font-semibold text-gray-900 text-xs mb-1">{{ $reply->buyer->username ?? 'Unknown User' }}</p>
                                                                                        <p class="text-gray-700 text-xs leading-relaxed">{{ $reply->comment }}</p>
                                                                                    </div>
                                                                                    <div class="flex items-center space-x-3 mt-1 ml-3">
                                                                                        <span class="text-xs text-gray-400">{{ $reply->created_at->diffForHumans() }}</span>
                                                                                        <button class="text-xs text-gray-400 hover:text-blue-600 font-medium">Like</button>
                                                                                        @if($reply->level < 2)
                                                                                            <button onclick="toggleReplyForm({{ $reply->id }})" class="text-xs text-gray-400 hover:text-blue-600 font-medium">Reply</button>
                                                                                        @endif
                                                                                        @if($reply->user_id === session('user_id'))
                                                                                            <form action="{{ route('posts.comment.delete', $reply->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus reply ini?')">
                                                                                                @csrf
                                                                                                @method('DELETE')
                                                                                                <button type="submit" class="text-xs text-red-400 hover:text-red-500 font-medium">Delete</button>
                                                                                            </form>
                                                                                        @endif
                                                                                    </div>

                                                                                    {{-- Reply to Reply Form --}}
                                                                                    @if($reply->level < 2)
                                                                                        <div id="reply-form-{{ $reply->id }}" class="hidden mt-2 ml-3">
                                                                                            <form action="{{ route('posts.reply', $reply->id) }}" method="POST">
                                                                                                @csrf
                                                                                                <div class="flex space-x-2">
                                                                                                    <img src="{{ session('buyer_avatar_url') }}" class="h-6 w-6 rounded-full flex-shrink-0" alt="Your Avatar">
                                                                                                    <div class="flex-1 flex space-x-2">
                                                                                                        <input type="text"
                                                                                                            name="comment"
                                                                                                            placeholder="Write a reply..."
                                                                                                            class="flex-1 px-3 py-1 bg-white border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-xs"
                                                                                                            required>
                                                                                                        <button type="submit"
                                                                                                                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-full font-medium transition-colors text-xs">
                                                                                                            Reply
                                                                                                        </button>
                                                                                                        <button type="button" onclick="toggleReplyForm({{ $reply->id }})"
                                                                                                                class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-3 py-1 rounded-full font-medium transition-colors text-xs">
                                                                                                            Cancel
                                                                                                        </button>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </form>
                                                                                        </div>
                                                                                    @endif

                                                                                    {{-- Nested Replies (Level 2) --}}
                                                                                    @if($reply->replies->count() > 0)
                                                                                        <div class="mt-3 space-y-2">
                                                                                            @foreach($reply->replies as $nestedReply)
                                                                                                <div class="flex space-x-2 ml-6 group">
                                                                                                    <img src="{{ $nestedReply->buyer->avatar_url }}" class="h-6 w-6 rounded-full flex-shrink-0" alt="Nested Replier Avatar">
                                                                                                    <div class="flex-1">
                                                                                                        <div class="bg-gray-50 rounded-xl px-3 py-2 group-hover:bg-gray-100 transition-colors">
                                                                                                            <p class="font-semibold text-gray-900 text-xs mb-1">{{ $nestedReply->buyer->username ?? 'Unknown User' }}</p>
                                                                                                            <p class="text-gray-700 text-xs leading-relaxed">{{ $nestedReply->comment }}</p>
                                                                                                        </div>
                                                                                                        <div class="flex items-center space-x-3 mt-1 ml-3">
                                                                                                            <span class="text-xs text-gray-400">{{ $nestedReply->created_at->diffForHumans() }}</span>
                                                                                                            <button class="text-xs text-gray-400 hover:text-blue-600 font-medium">Like</button>
                                                                                                            @if($nestedReply->user_id === session('user_id'))
                                                                                                                <form action="{{ route('posts.comment.delete', $nestedReply->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus reply ini?')">
                                                                                                                    @csrf
                                                                                                                    @method('DELETE')
                                                                                                                    <button type="submit" class="text-xs text-red-400 hover:text-red-500 font-medium">Delete</button>
                                                                                                                </form>
                                                                                                            @endif
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            @endforeach
                                                                                        </div>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="flex items-center justify-center h-full text-gray-500">
                                                <div class="text-center">
                                                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                                    </svg>
                                                    <p class="text-sm">No comments yet. Be the first to comment!</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Comment Form - Fixed at Bottom --}}
                                    <div class="p-6 border-t border-gray-200 bg-gray-50">
                                        <form action="{{ route('posts.comment', $post->id) }}" method="POST">
                                            @csrf
                                            <div class="flex space-x-3">
                                                <img src="{{ session('buyer_avatar_url') }}" class="h-10 w-10 rounded-full flex-shrink-0" alt="Your Avatar">
                                                <div class="flex-1 flex space-x-2">
                                                    <input type="text"
                                                        name="comment"
                                                        placeholder="Write a thoughtful comment..."
                                                        class="flex-1 px-4 py-3 bg-white border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                                        required>
                                                    <button type="submit"
                                                            class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-full font-medium transition-colors flex items-center space-x-2">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                                        </svg>
                                                        <span class="hidden sm:inline">Send</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </article>
                @endforeach
            </div>

            <div class="text-center mt-10">
                <button class="bg-white hover:bg-gray-50 text-gray-700 font-medium py-3 px-8 rounded-full border border-gray-200 hover:border-gray-300 transition-all shadow-sm hover:shadow-md">
                    Load More Posts
                </button>
            </div>
        @else
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-medium text-gray-900 mb-2">No posts yet</h3>
                <p class="text-gray-500 mb-8">Be the first to share something amazing with the community!</p>
                <button
                    onclick="document.getElementById('modal-create').classList.remove('hidden')"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-8 py-3 rounded-full font-medium transition-colors">
                    Create Your First Post
                </button>
            </div>
        @endif
    </div>
                    {{-- Image Modal for Full View --}}
            <div id="imageModal" class="hidden fixed inset-0 bg-black/90 backdrop-blur-sm flex items-center justify-center z-50 p-4 transition-opacity duration-300">
                <div class="relative max-w-4xl max-h-full">
                    {{-- Tombol close --}}
                    <button onclick="closeImageModal()"
                            class="absolute top-4 right-4 text-white hover:text-gray-300 z-10">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>

                    {{-- Gambar ditampilkan di sini --}}
                    <img id="modalImage"
                        src=""
                        class="max-w-full max-h-screen w-auto h-auto object-contain rounded-lg shadow-lg transform scale-95 transition-transform duration-300 ease-out cursor-zoom-out" />
                </div>
            </div>

            {{-- Script Modal --}}
            <script>
                function openImageModal(imageSrc) {
                    const modal = document.getElementById('imageModal');
                    const modalImage = document.getElementById('modalImage');

                    modalImage.src = imageSrc;
                    modal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';

                    // Animasi zoom-in
                    setTimeout(() => {
                        modalImage.classList.remove('scale-95');
                        modalImage.classList.add('scale-100');
                    }, 10);
                }

                function closeImageModal() {
                    const modal = document.getElementById('imageModal');
                    const modalImage = document.getElementById('modalImage');

                    // Animasi zoom-out sebelum hide
                    modalImage.classList.remove('scale-100');
                    modalImage.classList.add('scale-95');

                    setTimeout(() => {
                        modal.classList.add('hidden');
                        document.body.style.overflow = 'auto';
                    }, 200);
                }

                // Close modal saat klik luar gambar
                document.getElementById('imageModal').addEventListener('click', function(e) {
                    if (e.target === this) closeImageModal();
                });

                // Tutup pakai ESC
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') closeImageModal();
                });
            </script>
</div>

<script>
// Character counter for description
document.getElementById('description').addEventListener('input', function() {
    const charCount = this.value.length;
    document.getElementById('char-count').textContent = charCount;
});

// Image preview functionality
document.getElementById('images').addEventListener('change', function(e) {
    const previewContainer = document.getElementById('preview-container');
    const previewImages = document.getElementById('preview-images');

    if (e.target.files.length > 0) {
        previewContainer.classList.remove('hidden');
        previewImages.innerHTML = '';

        Array.from(e.target.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative';
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-20 object-cover rounded-lg">
                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center rounded-lg opacity-0 hover:opacity-100 transition-opacity">
                        <span class="text-white text-xs">${file.name}</span>
                    </div>
                `;
                previewImages.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    } else {
        previewContainer.classList.add('hidden');
    }
});

// Close modal when clicking outside
document.getElementById('modal-create').addEventListener('click', function(e) {
    if (e.target === this) {
        this.classList.add('hidden');
    }
});
</script>
<script>
        // Function to open comment modal
        function openCommentModal(postId) {
            const modal = document.getElementById(`comment-modal-${postId}`);
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Auto-focus comment input
            setTimeout(() => {
                const commentInput = modal.querySelector('input[name="comment"]');
                if (commentInput) {
                    commentInput.focus();
                }
            }, 100);
        }

        // Function to close comment modal
        function closeCommentModal(postId) {
            const modal = document.getElementById(`comment-modal-${postId}`);
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';

            // Close all open reply forms when closing modal
            const replyForms = modal.querySelectorAll('[id^="reply-form-"]');
            replyForms.forEach(form => {
                form.classList.add('hidden');
            });
        }

        // Function to toggle reply form
        function toggleReplyForm(commentId) {
            const replyForm = document.getElementById(`reply-form-${commentId}`);
            const isHidden = replyForm.classList.contains('hidden');

            // Close all other reply forms first
            const allReplyForms = document.querySelectorAll('[id^="reply-form-"]');
            allReplyForms.forEach(form => {
                form.classList.add('hidden');
            });

            // Toggle current reply form
            if (isHidden) {
                replyForm.classList.remove('hidden');
                // Focus on the reply input
                setTimeout(() => {
                    const replyInput = replyForm.querySelector('input[name="comment"]');
                    if (replyInput) {
                        replyInput.focus();
                    }
                }, 100);
            }
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('bg-black/60')) {
                const postId = e.target.id.split('-')[2];
                closeCommentModal(postId);
            }
        });

        // Close modal with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const openModals = document.querySelectorAll('[id^="comment-modal-"]:not(.hidden)');
                openModals.forEach(modal => {
                    const postId = modal.id.split('-')[2];
                    closeCommentModal(postId);
                });
            }
        });

        // Handle form submissions with better UX
        document.addEventListener('DOMContentLoaded', function() {
            // Handle comment and reply form submissions
            const commentForms = document.querySelectorAll('form[action*="/comment"], form[action*="/reply"]');

            commentForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const submitButton = form.querySelector('button[type="submit"]');
                    const originalText = submitButton.textContent;

                    // Disable button and show loading state
                    submitButton.disabled = true;
                    submitButton.textContent = 'Sending...';

                    // Re-enable after a short delay (form will redirect anyway)
                    setTimeout(() => {
                        submitButton.disabled = false;
                        submitButton.textContent = originalText;
                    }, 3000);
                });
            });
        });
</script>

{{-- Add this CSS for the modal --}}
<style>
.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 3px;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
</style>
@endsection