@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="p-5 bg-white rounded">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <form action="{{route('questions.update', $question->id)}}" method="post">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label>Question</label>
                            <textarea name="question" type="text" class="form-control form-control-sm" placeholder="Question" rows="4" required>{{ $question->question }}</textarea>
                        </div>
                        <div class="options"></div>
                        <button type="submit" class="btn btn-sm btn-outline-primary float-right" onclick="return confirm('Are you sure to update?')">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('script')
    <script>

        $(document).ready(function (){
            let answers = {!! $question->options !!}
                answers.forEach(function (answer){
                    $(".options").append(`<div class="form-group">
                                <input value="${answer.option}" name="options[${answer.id}]" type="text" class="form-control form-control-sm" required>
                            </div>`)
            })
        })
    </script>
@endsection
