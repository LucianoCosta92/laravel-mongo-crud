@extends('posts.theme')
    @section('content')
        <div class="container mt-5">

                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card shadow">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">Post Details</h4>
                                <a href="{{ route('posts.index') }}" class="btn btn-primary mb-3">Back</a>
                            </div>

                            <div class="card-body">
                                <h4 class="card-title mb-3">{{ $post->title }}</h4>
                                <hr>
                                <p class="card-text text-muted" style="line-height:1.7;">{{ $post->body }}</p>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    @endsection
