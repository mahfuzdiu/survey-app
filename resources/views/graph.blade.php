@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="flex-center position-ref full-height">
                <div class="content">
                    @if(!\Illuminate\Support\Facades\Cookie::get('voted'))
                        <form style="font-size: 20px; width: 400px;" action="{{route('submit.vote')}}" method="post">
                            @csrf

                            <p class="question">{{$question->question}}</p>
                            @foreach($question->options as $option)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="option_id" id="{{$option->id}}" value="{{$option->id}}">
                                    <label class="form-check-label" for="{{$option->id}}">
                                        {{ucfirst($option->option)}}
                                    </label>
                                </div>
                            @endforeach

                            <button class="btn btn-sm btn-primary float-right" type="submit">
                                <span class="pl-3 pr-3 pt-2 pb-2">SAVE</span>
                            </button>
                        </form>
                    @else
                        <div style="width: 400px">
                            <p class="question">{{$question->id}} . {{$question->question}}</p>
                            @foreach($question->options as $option)
                                <div class="ab-progress" data-height="20" data-radius="3" data-progress data-tooltip="true" data-value="{{$option->vote_count}}" data-title="{{ucfirst($option->option)}}"></div>
                            @endforeach

                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

@section('css')
    <style>
        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            box-shadow: 0 0 1px grey;
            padding: 20px 30px;
            border-radius: 5px;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        .progress-indicator-inner{
            bottom: -15px !important;
            padding: 5px 5px 5px !important;
        }

        .question{
            font-size: 16px;
        }

    </style>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="{{asset('plugins/progress_bar/js/progressBar.min.js')}}"></script>
@endsection
