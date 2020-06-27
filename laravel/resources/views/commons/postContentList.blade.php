<ul class="list-unstyled">
    <li>
        【{{ $post->title }}】
    </li>
        <div class="ml-3">
            <li>
                日時：{{ substr($post->date_time, 0, 16) . '~' . substr($post->end_time, 0, 5) }}
            </li>
            <li>
                場所：{{ $post->place }}
            </li>
            <li>
                住所：{{ $post->address }}
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
                応募締切：{{ substr($post->deadline, 0, 16) }}
            </li>
            <li>
                募集人数：{{ $post->people }}
            </li>
        </div>
</ul>
<p>
    {{ $post->remarks }}
</p>