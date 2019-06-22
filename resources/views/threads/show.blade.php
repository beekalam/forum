@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="level">
                            <span class="flex">
                                <a href="{{ route('profile', $thread->creator) }}"> {{ $thread->creator->name }} </a> posted:
                                {{ $thread->title }}
                            </span>

                            @if(Auth::check())
                                <form action="{{ $thread->path() }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="btn btn-primary">Delete</button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <div class="card-body">
                        {{ $thread->body }}
                    </div>

                </div>

                @foreach($replies as $reply)
                    @include("threads.reply")
                @endforeach

                <div class="mt-2">{{ $replies->links() }}</div>


                @if(auth()->check())
                    <form method="POST" action="{{ $thread->path() . "/replies" }}" class="mt-2">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <textarea name="body" id="body" cols="30" rows="10" class="form-control"
                                      placeholder="Have something to say?"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Post</button>
                    </form>
                @else
                    <div class="text-center">
                        <p>Please <a href="{{ route('login') }}">sign in</a>to participate.</p>
                    </div>
                @endif
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        This thread was published {{ $thread->created_at->diffForHumans() }} by
                        <a href="">{{ $thread->creator->name }}</a> and has currently {{ $thread->replies_count }}
                        {{ str_plural('comment', $thread->replies_count) }}.
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
