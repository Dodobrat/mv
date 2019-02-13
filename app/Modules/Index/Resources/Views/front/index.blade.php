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
                <a id="modal-btn">
                    @if(!empty($project->media->first()))
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
    </div>

    <div id="my-modal" class="custom-modal">
        <div class="custom-modal-content">
            <div class="custom-modal-header">
                <button class="close">
                    &#x276C;
                </button>
                <h3>TITLE</h3>
            </div>
            <div class="row justify-content-center align-items-center px-0 px-sm-0 px-md-0 px-lg-3 py-0 py-sm-0 py-md-3 py-lg-5">
                <div class="col-12">

                    <div class="tab-content" id="project-view-container">

                        <div class="tab-pane fade show active project-view" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <img src="https://via.placeholder.com/300C/O https://placeholder.com/" alt="">
                        </div>
                        <div class="tab-pane fade project-view" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <img src="https://via.placeholder.com/300C/O https://placeholder.com/" alt="">
                        </div>
                        <div class="tab-pane fade project-view" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                            <img src="https://via.placeholder.com/300C/O https://placeholder.com/" alt="">
                        </div>

                    </div>

                    <div class="container">
                        <ul class="nav nav-pills justify-content-lg-center" id="project-view-pills" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active"
                                   id="pills-home-tab"
                                   data-toggle="pill"
                                   href="#pills-home"
                                   role="tab"
                                   aria-controls="pills-home"
                                   aria-selected="true">
                                    <img src="https://via.placeholder.com/150C/O https://placeholder.com/" alt="">
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">
                                    <img src="https://via.placeholder.com/150C/O https://placeholder.com/" alt="">
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">
                                    <img src="https://via.placeholder.com/150C/O https://placeholder.com/" alt="">
                                </a>
                            </li>
                        </ul>
                    </div>


                </div>
            </div>

        </div>
    </div>


    <div style="height: 2000px;"></div>

@endsection