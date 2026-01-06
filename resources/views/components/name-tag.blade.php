<div class="col-xl-2 col-sm-3 mb-xl-0 mb-3 py-2">
    <div class="card {{$user->total() < $user->hard_limit?'disabled-name-tag':''}} " id="name-tag-{{$user->id}}" >
        <a class="nav-link" href="{{$user->total() < $user->hard_limit?'':route('user-select', $user)}}">
            <div class="card-body p-1">
                <div class="row">
                    <div >
                        <div class="numbers">
                            <h5 class="text-start font-weight-bolder mb-1">
                                {{$user->name}}
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <span class="text-date">
                        {{($user->lastTally?$user->lastTally->created_at:'')}}
                    </span>
                    <span class="text-success text-sm font-weight-bolder text-end">{{currency($user->total())}}</span>
                </div>
            </div>
        </a>
    </div>
</div>
<script>
    var element = document.getElementById('name-tag-{{$user->id}}')
    element.addEventListener("click", function(e) {
        var temp = document.getElementById('name-tag-{{$user->id}}')
        temp.classList.add('highlight');
        setTimeout(() => temp.classList.remove('highlight'), 2000);
    });
</script>
