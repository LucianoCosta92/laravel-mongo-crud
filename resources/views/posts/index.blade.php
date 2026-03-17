@extends('posts.theme')
    @section('content')
        <div class="card mt-5">
            <h3 class="card-header p-3">MongoDB CRUD App</h3>
            <div class="card-body">

                @session('success')
                    <div class="alert alert-success">
                        {{ $value }}
                    </div>
                @endsession

                <a href="{{ route('posts.create') }}" class="btn btn-success mb-3">Create Post</a>

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="300px">ID</th>
                            <th>Title</th>
                            <th>Body</th>
                            <th width="250px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $post)
                        <tr>
                            <td>{{ $post->id }}</td>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->body }}</td>
                            <td>
                                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-warning btn-sm">Show</a>
                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ route('posts.destroy', $post->id) }}" onsubmit="return confirm('Are you sure you want to delete this post?')" method="post" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endsection

