<reply :attributes="{{ $reply }}" inline-template v-cloak>

    <div id="reply-{{ $reply->id }}" class="card" style="margin-top:8px">
        <div class="card-header">
            <div class="level">
                <h6 class="flex">
                    <a href="{{ route('profile', $reply->owner) }}" class="flex">
                        {{ $reply->owner->name }}
                    </a>
                    said {{ $reply->created_at->diffForHumans() }} ...
                </h6>

                @if(Auth::check())
                    <div>
                        <favorite :reply="{{ $reply }}"></favorite>
                    </div>
                @endif

            </div>
        </div>

        <div class="card-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body">{{ $reply->body }}</textarea>
                </div>

                <button class="btn btn-outline-primary btn-xs btn-link" @click="update">Update</button>
                <button class="btn btn-xs btn-link" @click="editing = false">Cancel</button>
            </div>

            <div v-else v-text="body"></div>
        </div>

        @can('update',$reply)
            <div class="card-footer level">
                <button class="btn btn-primary btn-xs mr-1" @click="editing = true">Edit</button>
                <button class="btn btn-danger btn-xs mr-1" @click="destroy">Delete</button>
            </div>
        @endcan
    </div>

</reply>
