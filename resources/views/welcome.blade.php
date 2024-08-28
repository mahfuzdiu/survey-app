<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $question ? $question->question : '' }}</title>

        {{--meta tags for facebook --}}
        <meta property="og:title" content="{{$question ? $question->question : ''}}" />
        <meta property="og:type" content="text/plain" />
        <meta property="og:url" content="{{ env('APP_URL') }}" />
{{--        <meta property="og:image" content="https://ia.media-imdb.com/images/rock.jpg" />--}}

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('plugins/progress_bar/css/progressBar.min.css') }}" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

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
                font-size: 16px; font-weight: bold;
                text-align: justify;
            }

        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/questions') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

{{--                        @if (Route::has('register'))--}}
{{--                            <a href="{{ route('register') }}">Register</a>--}}
{{--                        @endif--}}
                    @endauth
                </div>
            @endif



                @if($question)
            <div class="content">
                @if(!\Illuminate\Support\Facades\Cookie::get('voted'))
                    <form style="font-size: 20px; width: 400px;" action="{{route('submit.vote')}}" method="post">
                        @csrf
                            <p class="question">{{$question->question}}</p>
                            @foreach($question->options as $option)
                                <div class="form-check" style="display: flex; margin-bottom: 2px;">
                                    <input class="form-check-input" type="radio" name="option_id" id="{{$option->id}}" value="{{$option->id}}">
                                    <label class="form-check-label font-weight-bold" style="font-size: 16px;" for="{{$option->id}}">
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
                        <p class="question">{{$question->question}}</p>
                        @foreach($question->options as $option)
                            <div class="ab-progress" data-height="20" data-radius="3" data-progress data-tooltip="true" data-value="{{$option->vote_count}}" data-title="{{ucfirst($option->option)}}"></div>
                        @endforeach

                    </div>
                @endif

                    @else
                        <p>No Data Available</p>

            @endif
            </div>
        </div>
    </body>
</html>


<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="{{asset('plugins/progress_bar/js/progressBar.min.js')}}"></script>

