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
        <div class="col-12">

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

                <ul class="nav nav-pills justify-content-lg-center" id="project-view-pills" role="tablist">

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