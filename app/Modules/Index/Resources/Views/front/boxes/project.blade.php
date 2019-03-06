@if(!empty($project))
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <button class="close"
            onclick="closeModal()">
                &#x276C;
            </button>
            <h3>{{ $project->title }}</h3>
        </div>
        <div class="row justify-content-center align-items-center px-0 px-sm-0 px-md-0 px-lg-3">
            <div class="col-12 d-none d-lg-block">

                <div id="carousel_{{ $project->id }}" class="carousel slide" data-ride="carousel">

                    <div class="carousel-inner">
                        @foreach($project->media as $media)
                        <div class="carousel-item @if($loop->first) active @endif">
                            @if(!empty($media))
                                <img src="{{ $media->getPublicPath() }}" alt="...">
                            @else
                                <img src="https://via.placeholder.com/300C/O https://placeholder.com/" alt="">
                            @endif
                        </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#carousel_{{ $project->id }}" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carousel_{{ $project->id }}" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>

                    <ol class="carousel-indicators list-inline">
                        @foreach($project->media as $thumbs)
                        <li class="list-inline-item {{ $loop->first ? 'active' : '' }}" data-target="#carousel_{{ $project->id }}" data-slide-to="{{ $loop->index }}">
                            @if(!empty($thumbs))
                                <img src="{{ $thumbs->getPublicPath() }}">
                            @else
                                <img src="https://via.placeholder.com/300C/O https://placeholder.com/" alt="">
                            @endif
                        </li>
                        @endforeach
                    </ol>

                </div>

            </div>
            <div class="col-12 d-block d-lg-none">
                <div class="tab-content" id="project-view-container">
                    @foreach($project->media as $media)
                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }} project-view" id="pills-{{ $media->id }}" role="tabpanel" aria-labelledby="pills-{{ $media->id }}-tab">
                            @if(!empty($media))
                                <img class="project-view-img" src="{{ $media->getPublicPath() }}">
                            @else
                                <img class="project-view-img" src="https://via.placeholder.com/300C/O https://placeholder.com/" alt="">
                            @endif
                        </div>
                    @endforeach
                </div>
                <div class="container">
                    <ul class="nav nav-pills justify-content-lg-center align-items-center" id="project-view-pills" role="tablist">
                        @foreach($project->media as $thumbs)
                            <li class="nav-item">
                                <a class="nav-link {{ $loop->first ? 'active' : '' }}"
                                   id="pills-{{ $thumbs->id }}-tab"
                                   data-toggle="pill"
                                   href="#pills-{{ $thumbs->id }}"
                                   role="tab"
                                   aria-controls="pills-{{ $thumbs->id }}"
                                   aria-selected="true">
                                    @if(!empty($thumbs))
                                        <img src="{{ $thumbs->getPublicPath() }}">
                                    @else
                                        <img src="https://via.placeholder.com/300C/O https://placeholder.com/" alt="">
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif