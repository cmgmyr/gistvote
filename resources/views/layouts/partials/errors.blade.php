@if (count($errors) > 0)
    <div class="alert alert-danger">
        <h3>Validation Failed!</h3>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
