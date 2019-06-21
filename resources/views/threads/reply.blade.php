<div class="card" style="margin-top:8px">
    <div class="card-header">
        <div class="level">
            <h6 class="flex">
                <a href="#" class="flex">
                    {{ $reply->owner->name }}
                </a>
                said {{ $reply->created_at->diffForHumans() }} ...
            </h6>


            <div>
                <form action="/replies/{{ $reply->id }}/favorites" method="post">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-primary btn-sm" {{ $reply->isFavorited() ? 'disabled':'' }}>
                        {{ $reply->favorites()->count() }} {{ str_plural('Favorite',$reply->favorites()->count()) }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="card-body">
        {{ $reply->body }}
    </div>
</div>
