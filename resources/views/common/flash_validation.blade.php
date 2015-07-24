@if(Session::has('flash_notification.validation'))
<ul>
    @foreach(Session::get('flash_notification.validation') as $error)
    <li>{{$error[0]}}</li>
    @endforeach
</ul>
@endif
