@extends('admin.layouts.admin')

@section('content')
    <div class="container">
        <h1>Alloha, Admin!</h1>
        <p>This is index page of DS Admin tools.</p>
        <p>You can change it appearence by changing the content of
            <strong>/resources/views/admin/index.blade.php</strong> view.</p>
    </div>

    <div class="container">
        {!! $provider->renderGrid() !!}
    </div>
@endsection
