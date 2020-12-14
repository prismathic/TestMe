@extends('layouts.main')
@section('title') {{$currentClass->name}} {{ucfirst($subject->name)}} Exam Results @endsection
@section('content')

    <div class="container" id="app" data-app="true">
        <h3 class="text-center mt-5">
            {{$currentClass->name}} {{$subject->name}} Examination Results
        </h3>
        <hr>

        <div class="row">
            <div class="col-md-8">
            EXAM DATE: <strong>{{$currentExam ? date('l, jS \o\f F Y', strtotime($currentExam->date)) : 'NIL'}} {{}}</strong>
            </div>
        <all-results :exams="{{$exams}}" :selected_exam="{{$currentExam}}" :iscurrentexam="{{$isLatestExam}}" :subject="{{$subject}}" :class-id="{{$currentClass->id}}"></all-results>
        </div>

        <table class="table table-sm mt-2 table-bordered text-center">

            <thead>
            <tr>
            <th>S/N</th>
                <th>EXAMINATION NUMBER</th>
                <th>NAME</th>
                <th>ACTUAL SCORE</th>
                <th>COMPUTED SCORE (/{{$currentExam->base_score ?? '-'}})</th>
            </tr>
            </thead>
            <tbody>
                @if ($students)
                    @foreach ($students as $student)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$student->examination_number}}</td>
                        <td>{{$student->fullName}}</td>
                        <td>{{$student->pivot->actual_score}}</td>
                        <td>{{$student->pivot->computed_score}}</td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5">
                            No submission has been made for this examination yet.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <script src="{{asset('/js/app.js')}}"></script>

@endsection

