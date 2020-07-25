<ul class="list-unstyled">
    <li>
        【{{ $post->title }}】
    </li>
        <div class="ml-3">
            <li class="end_time-float">
                日時：{{ $post->date_time }}
            </li>
            <li class="end_time">
                {{ '~' . ' ' . $post->end_time }}
            </li>
            <li class="d-inline-block place">
                場所：
            </li>
            <li class="d-inline-block place-content">
                {{ $post->place }}
            </li>
            <li class="d-inline-block address">
                住所：
            </li>
            <li class="d-inline-block address-content">
                {{ $post->address }}
            </li>
            <li>
                場所予約：{{ $post->reservation }}
            </li>
            <li>
                参加費用：{{ $post->expense }}
            </li>
            <li>
                使用球：{{ $post->ball }}
            </li>
            <li>
                応募締切：{{ $post->deadline }}
            </li>
            <li>
                募集人数：{{ $post->participate_users()->count() . '/' . $post->people }}人
            </li>
        </div>
</ul>
<p class="ml-3 mt-3">
    {{ $post->remarks }}
</p>