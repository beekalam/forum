@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create a new Thread</div>

                    <div class="card-body">
                        <form action="/threads" method="POST">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title">
                            </div>


                            <div class="form-group">
                                <label for="Body">Body</label>
                                <textarea class="form-control" name="body" id="body" cols="30" rows="10"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Publish</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
