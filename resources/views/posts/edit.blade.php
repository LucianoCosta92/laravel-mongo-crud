@extends('posts.theme')
    @section('content')
        <div class="card mt-5">
            <h3 class="card-header p-3">Edit Post</h3>
            <div class="card-body">

                <a href="{{ route('posts.index') }}" class="btn btn-primary mb-3">Back</a>

                <form action="{{ route('posts.update', $post->id) }}" method="post">
                    @csrf
                    @method('PUT')

                    <div class="mt-2">
                        <label for="title">Title:</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ $post->title }}">
                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mt-2">
                        <label for="body">Body:</label>
                        <textarea name="body" id="body" class="form-control">{{ $post->body }}</textarea>
                        @error('body')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mt-2">
                        <button class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    @endsection
