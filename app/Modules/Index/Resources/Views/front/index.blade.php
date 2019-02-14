@extends('layouts.app')
@section('content')

    <div class="container my-5">
        <div class="filter-section justify-content-center align-items-center">
            <button class="filter-button active" data-filter="all">All</button>
            @foreach($categories as $category)
                <button class="filter-button"
                        data-filter="{{ strtolower($category->title) }}">
                    {{ $category->title }}
                </button>
            @endforeach
        </div>
    </div>


    <div class="container-fluid">
        <div class="card-columns portfolio-grid">

            @foreach($projects as $project)

            <div class="card portfolio-grid-item filter {{ strtolower($project->category->title ) }}" data-aos="zoom-in">
                <a id="modal-btn"
                   onclick="openModal( '{{ $project->id }}','{{ route('projects.getProject') }}','{{ $project->slug }}')">
                    @if($project->media->isNotEmpty())
                        <img src="{{ $project->media->first()->getPublicPath() }}" class="card-img-top" alt="...">
                    @else
                        <img src="https://via.placeholder.com/150C/O https://placeholder.com/" class="card-img-top" alt="...">
                    @endif
                </a>
                <div class="overlay">
                    <h4 class="card-overlay-title">
                        {{ $project->title }}
                        <br>
                        <span class="card-overlay-second">
                            {!! $project->description !!}
                        </span>
                    </h4>

                </div>

            </div>

            @endforeach

        </div>

        <div class="loader-container">
            <div id="loader"></div>
        </div>
    </div>



    <div id="my-modal" class="custom-modal">
        @include('index::front.boxes.project')
    </div>


    <div style="height: 2000px;"></div>

@endsection