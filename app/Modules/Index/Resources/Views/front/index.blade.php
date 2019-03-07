@extends('layouts.app')
@section('content')

    <div class="main-categories-section">
        @foreach($categories as $category)
            <div class="main-category-btn"
                data-slug="{{ $category->slug }}"
                data-url="{{ route('categories.getSubCategories') }}"
                data-route="{{ route('index') }}"
                @if(!empty($category->media->first()))
                    style="background-image: url('{{ $category->media->first()->getPublicPath() }}');"
                @else
                    style="background-image: url('https://via.placeholder.com/150C/O https://placeholder.com/');"
                @endif>
                {{ $category->title }}
            </div>
        @endforeach
    </div>

    <div class="sub-categories-section" id="subCatSection">
        @if(!empty($categories) && $categories->isNotEmpty())

            @include('index::front.boxes.sub_categories', ['sub_categories' => $sub_categories])

        @endif
    </div>

    <div class="container-fluid">
        <div class="card-columns portfolio-grid endless-pagination" id="portfolio">
            @if(!empty($sub_categories) && $sub_categories->isNotEmpty())

                @include('index::front.boxes.projects', ['projects' => $projects])

            @endif
        </div>
    </div>

    <h3 class="empty text-center">{{ trans('index::front.nothing_to_show') }}</h3>

<div class="aspin">
    <div class="spinner"></div>
</div>

<div id="top-projects">
    <div class="container">
        <div class="projects-heading-top">
            {{ trans('index::front.top_projects') }}
        </div>
        <div class="card-columns top-portfolio-grid">

            @foreach($top_projects as $top_project)

                <div class="card portfolio-grid-item">
                    <a id="modal-btn"
                       onclick="openModal( '{{ $top_project->id }}','{{ route('projects.getProject') }}','{{ $top_project->slug }}')">
                        @if($top_project->media->isNotEmpty())
                            <img src="{{ $top_project->media->first()->getPublicPath() }}" class="card-img-top" alt="...">
                        @else
                            <img src="https://via.placeholder.com/150C/O https://placeholder.com/" class="card-img-top" alt="...">
                        @endif
                    </a>
                    <div class="overlay">
                        <h4 class="card-overlay-title">
                            {{ $top_project->title }}
                            <br>
                            <span class="card-overlay-second">
                    {!! $top_project->description !!}
                </span>
                        </h4>

                    </div>

                </div>

            @endforeach

        </div>
    </div>
</div>


@endsection