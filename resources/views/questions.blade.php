@extends('layouts/BaseLayout')

@section('container')

<div class="col-md-10 column ">
    <p class="lead" style="margin-bottom: 0; margin-top: 10px;">Išspręsta {{ $progress }}%</p>
    <div class="progress" style="margin-bottom: 15px;">
        <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%;"></div>
    </div>

    <form action="{{ route('next') }}" method="post">
        @csrf
        <input type="hidden" name="question_id" value="{{ $current_question->id }}">
        <input type="hidden" name="test_id" value="{{ $test_id }}">
        <div class="panel panel-primary">
            <div class="panel-heading" style="margin-bottom: 15px;">
                <h3 class="panel-title">
                    {{ $current_question->question_name }}
                </h3>
            </div>
            <div class="panel-body">
                @foreach($current_question->Answers as $answer)
                    <div class="radio">
                        <label>
                            <input type="radio" name="answer_id" id="optionsRadios1" value="{{ $answer->id }}"> {{ $answer->answer }}
                        </label>
                    </div>
                @endforeach
            </div>
            <div class="panel-footer" style="margin-top: 15px; display: flex; justify-content: space-between">
                <a href="{{ route('selectNewTest') }}" class="btn btn-warning ml-2">Spręsti kitą testą</a>
                <a href="{{ route('resetTest') }}" class="btn btn-danger ml-2">Spręsti testą iš naujo</a>
                <input type="submit" class="btn btn-success " name="next" value="Kitas Klausimas">
            </div>
        </div>
    </form>

</div>
@endsection
