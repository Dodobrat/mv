@extends('layouts.app')
@section('content')

    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        @foreach($types as $type)
        <li class="nav-item">
            <a class="nav-link {{ $loop->first ? 'active' : '' }}"
               id="pills-{{ $type->slug }}-tab"
               data-toggle="pill"
               href="#pills-{{ $type->slug }}"
               role="tab"
               aria-controls="pills-{{ $type->slug }}"
               aria-selected="true"
               onclick="">
                {{ $type->title }}
            </a>
        </li>
        @endforeach
    </ul>

    <div class="tab-content" id="pills-tabContent">
        @foreach($types as $content)
            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="pills-{{ $content->slug }}" role="tabpanel" aria-labelledby="pills-{{ $content->slug }}-tab">


                <div class="container my-5">
                    <div class="filter-section justify-content-center align-items-center">
                        <button class="filter-button active" data-filter="{{ strtolower($content->slug) }}">All</button>

                        @foreach($content->categories as $category)
                            <button class="filter-button"
                                    data-filter="{{ strtolower($category->slug) }}">
                                {{ $category->title }}
                            </button>
                        @endforeach

                    </div>
                </div>

                {{--{{ dd($content->projects) }}--}}

                <div class="container-fluid">
                    <div class="card-columns portfolio-grid endless-pagination" data-route="{{ route('index') }}" data-next-page="{{ $projects->count() }}">

                        @include('index::front.boxes.projects', compact($projects))

                    </div>

                    <div class="loader-container">
                        <div id="loader"></div>
                    </div>

                    <div class="projects-loader-container">
                        <div id="loader"></div>
                    </div>
                </div>



            </div>
        @endforeach
    </div>

@endsection