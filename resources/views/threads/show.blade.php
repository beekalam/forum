@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="#"> {{ $thread->creator->name }} </a> posted:
                        {{ $thread->title }}
                    </div>

                    <div class="card-body">
                        {{ $thread->body }}
                    </div>

                </div>
            </div>
        </div>


        <div class="row justify-content-center" style="margin-top:8px;">
            <div class="col-md-8">
                @foreach($thread->replies as $reply)
                    @include("threads.reply")
                @endforeach
            </div>
        </div>

        @if(auth()->check())
            <div class="row justify-content-center pt-5">
                <div class="col-md-8 col-md-offset-2">
                    <form method="POST" action="{{ $thread->path() . "/replies" }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <textarea name="body" id="body" cols="30" rows="10" class="form-control"
                                      placeholder="Have something to say?"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Post</button>
                    </form>
                </div>
            </div>
        @else
            <div class="text-center">
                <p>Please <a href="{{ route('login') }}">sign in</a>to participate.</p>
            </div>
        @endif

    </div>
@endsection
