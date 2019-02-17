@foreach($projects as $project)

    <div class="card portfolio-grid-item filter @foreach($project->category->types as $type) {{ strtolower($type->id) }} @endforeach {{ strtolower($project->category->title ) }}">
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