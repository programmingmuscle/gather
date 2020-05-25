<ul class="list-unstyled">
    <li>
        【{{ $concern->title }}】
    </li>
    <li>
        日時：{{ substr($concern->date_time, 0, 16) . '~' . substr($concern->end_time, 0, 5) }}
    </li>
    <li>
        場所：{{ $concern->place }}
    </li>
    <li>
        住所：{{ $concern->address }}
    </li>
    <li>
        場所予約：{{ $concern->reservation }}
    </li>
    <li>
        参加費用：{{ $concern->expense }}
    </li>
    <li>
        使用球：{{ $concern->ball }}
    </li>
    <li>
        応募締切：{{ substr($concern->deadline, 0, 16) }}
    </li>
    <li>
        募集人数：{{ $concern->people }}
    </li>
</ul>
<p>
    {{ $concern->remarks }}
</p>