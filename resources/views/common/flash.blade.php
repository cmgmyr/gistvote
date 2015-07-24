@if(Session::has('flash_notification.message'))
<div class="alert alert-{{Session::get('flash_notification.level')}} @if(Session::get('flash_notification.level') != 'danger') alert-disappear @endif">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
    <h4>{{Session::get('flash_notification.message')}}</h4>
    @include('common.flash_validation')
</div>
@endif
