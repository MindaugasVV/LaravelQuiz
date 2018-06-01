@extends('layouts/BaseLayout')

@section('container')

    <div class="col-md-10 column ">
        <p class="lead" style="margin-bottom: 0; margin-top: 10px;">Išspręsta {{ $progress }}%</p>
        <div class="progress" style="margin-bottom: 15px;">
            <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%;"></div>
        </div>

        <h1>Testas baigtas</h1>
            <h3>Jūsų rezultatas:</h3>
            <div>
                <div style="margin:5px">{{ $points }} Taškai</div>
                    <div style="display: flex;">
                        <a href="{{ route('showSave') }}" class="btn btn-success">Išsaugoti rezultatą</a>
                        <a href="{{ route('resetTest') }}" class="btn btn-primary ml-2">Spręsti testą iš naujo</a>
                        <a href="{{ route('selectNewTest') }}" class="btn btn-warning ml-2">Spręsti kitą testą</a>
                    </div>
            </div>
        <h1>Jūsų pasirinkimai: </h1>
        <table class="table">
            <thead>
            <tr>
                <th>Klausimas</th>
                <th>Atsakymai</th>
                <th>Atsakymo taškai</th>
            </tr>
            </thead>
            <tbody>
            @foreach($questions as $question)
                <tr>
                    <td>{{ $question->question_name }}</td>
                    <td>
                        @foreach($question->Answers as $answer)
                            <li style="list-style-type: none; @if(in_array($answer->id, $answers)){{'color:red;'}}@endif" >{{ $answer->answer }}</li>
                        @endforeach
                    </td>
                    <td>
                        @foreach($question->Answers as $answer)
                            <li style="list-style-type: none; @if(in_array($answer->id, $answers)){{'color:red;'}}@endif" >{{ $answer->points }}</li>
                        @endforeach
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>



@endsection