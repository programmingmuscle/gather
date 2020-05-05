<ul class="list-unstyled">
    <li>
        【{{ $post->title }}】
    </li>
    <li>
        日時：{{ $post->date_time }}
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
        応募締切：{{ $post->deadline }}
    </li>
    <li>
        募集人数：{{ $post->people }}
    </li>
</ul>
<p>
    {{ $post->remarks }}
</p>