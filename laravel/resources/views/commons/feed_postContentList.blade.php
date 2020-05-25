<ul class="list-unstyled">
    <li>
        【{{ $feed_post->title }}】
    </li>
    <li>
        日時：{{ substr($feed_post->date_time, 0, 16) . '~' . substr($feed_post->end_time, 0, 5) }}
    </li>
    <li>
        場所：{{ $feed_post->place }}
    </li>
    <li>
        住所：{{ $feed_post->address }}
    </li>
    <li>
        場所予約：{{ $feed_post->reservation }}
    </li>
    <li>
        参加費用：{{ $feed_post->expense }}
    </li>
    <li>
        使用球：{{ $feed_post->ball }}
    </li>
    <li>
        応募締切：{{ substr($feed_post->deadline, 0, 16) }}
    </li>
    <li>
        募集人数：{{ $feed_post->people }}
    </li>
</ul>
<p>
    {{ $feed_post->remarks }}
</p>