@include("parts.header")
@if($users)
    <ul>
        @foreach($users as $user)
        <li>{{ $user->meno }} {{ $user->email }}
            <a href="{{ route("delete", ['id' => $user->id]) }}">DELETE</a> </li>
        @endforeach
    </ul>
@else
    <b>Nemam ziadnych pouzivatelov</b>
@endif
@include("parts.footer")
