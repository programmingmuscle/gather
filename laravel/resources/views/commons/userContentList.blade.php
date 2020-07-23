<ul class="list-unstyled">
    <li class="d-inline-block residence">
        居住地：
    </li>
    <li class="d-inline-block residence-content">
        {{ $user->residence }}
    </li>  
    <li>
        性別：{{ $user->gender }}
    </li>
    <li>
        年齢：{{ $user->age }}
    </li>
    <li>
        野球歴：{{ $user->experience }}
    </li>
    <li>
        ポジション：{{ $user->position }}
    </li>
</ul>
<p class="mt-3">    
    {{ $user->introduction }}
</p>