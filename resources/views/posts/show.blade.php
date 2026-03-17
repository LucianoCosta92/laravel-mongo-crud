@extends('posts.theme')
    @section('content')
        <div class="card mt-5">
            <h3 class="card-header p-3">Show Post</h3>
                <div class="card-body">
                    <a href="{{ route('posts.index') }}" class="btn btn-primary mb-3">Back</a>

                    <div class="card" style="width: 18rem;">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <h4 class="card-title">{{ $post->title }}</h4>
                                <p class="card-text">{{ $post->body }}</p>
                        </div>
                    </div>
                </div>
        </div>
    @endsection
