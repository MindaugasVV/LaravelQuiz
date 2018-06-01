@extends('layouts/BaseLayout')

@section('container')

    <div style="padding-top: 30px;">
        <h1>Testai</h1>
        @foreach($tests as $test)
            <a href="{{ route('testas', $test->id) }}" class="btn btn-secondary">{{ $test->name }}</a>
        @endforeach
    </div>

@endsection