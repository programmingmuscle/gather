<ul class="list-unstyled">
    <li>
        【{{ $participation->title }}】
    </li>
    <li>
        日時：{{ substr($participation->date_time, 0, 16) . '~' . substr($participation->end_time, 0, 5) }}
    </li>
    <li>
        場所：{{ $participation->place }}
    </li>
    <li>
        住所：{{ $participation->address }}
    </li>
    <li>
        場所予約：{{ $participation->reservation }}
    </li>
    <li>
        参加費用：{{ $participation->expense }}
    </li>
    <li>
        使用球：{{ $participation->ball }}
    </li>
    <li>
        応募締切：{{ substr($participation->deadline, 0, 16) }}
    </li>
    <li>
        募集人数：{{ $participation->people }}
    </li>
</ul>
<p>
    {{ $participation->remarks }}
</p>