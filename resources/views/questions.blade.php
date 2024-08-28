@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header">
                        {{ __('Dashboard') }}

                        <button type="button" class="btn btn-sm btn-outline-primary float-right" data-toggle="modal"
                                data-target="#exampleModal">
                            Add Question
                        </button>
                    </div>

                    @include('modal/question-add')
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col" class="text-center">ID</th>
                            <th scope="col">Question</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach( $questions as $key => $question)
                            <tr>
                                <td class="text-center">{{ $question->id }}</td>
                                <td>{{ $question->question }}</td>
                                <td class="d-flex justify-content-center">




                                    @if($question->is_active)
                                        <a href="{{route('questions.status', $question->id)}}"
                                           class=" btn btn-sm btn-success ml-1"
                                        >
                                            Activated
                                        </a>

                                    @else
                                        <a href="{{route('questions.status', $question->id)}}"
                                           class="btn btn-sm btn-outline-secondary ml-1"
                                        >
                                            Deactivated
                                        </a>
                                    @endif
                                    <a href="{{route('questions.watch-graph', $question->id)}}"
                                       class="btn btn-sm btn-outline-info ml-1 mr-1"
                                       target="_blank"
                                    >
                                        Graph
                                    </a>

                                        <a href="{{route('questions.edit', $question->id)}}"
                                           class=" btn btn-sm btn-outline-primary"
                                           target="_blank"
                                        >
                                            Edit
                                        </a>

                                    <form action="{{route('questions.destroy', $question->id)}}" method="post">
                                        @method('DELETE')
                                        @csrf
                                        <input class="btn btn-sm btn-outline-danger ml-1" type="submit" value="Delete" onclick="return confirm('Are you sure to delete this question?')"/>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        let optionCounter = 1
        $("#addOptions").click(function () {
            optionCounter++

            if(optionCounter <= 5){
                $(".options").append(`
                <div class="form-group">
                    <input name="options[]" type="text" class="form-control form-control-sm" placeholder="Option ${optionCounter}" required>
                </div>
            `)
            } else{
                confirm("Can not add more than 5 options")
            }
        })
    </script>
@endsection



