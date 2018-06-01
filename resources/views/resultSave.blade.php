@extends('layouts/BaseLayout')

@section('container')
    <div style="padding-top: 30px; max-width: 500px;">
        <form action="{{ route('saveResult') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="name">Vardas</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Įveskite savo vardą">
                <small id="emailHelp" class="form-text text-muted">Viskas yra anonimiška</small>
            </div>

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <input type="submit" class="btn btn-primary" value="Saugoti" name="save">
        </form>

    </div>
@endsection