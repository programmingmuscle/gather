<ul class="list-unstyled">
    <li>
        居住地：{{ $user->residence }}
    </li>
    <li class="gender">
        性別：{{ $user->gender }}
    </li>
    <li class="age">
        年齢：{{ $user->age }}
    </li>
    <li class="experience">
        野球歴：{{ $user->experience }}
    </li>
    <li>
        ポジション：{{ $user->position }}
    </li>
</ul>
<p>
    {{ $user->introduction }}
</p>