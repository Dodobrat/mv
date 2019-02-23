@extends('layouts.app')
@section('content')

    <div class="main-categories-section">
        @foreach($categories as $category)
            <button class="main-category-btn"
                data-slug="{{ $category->slug }}"
                data-url="{{ route('categories.getSubCategories') }}"
                data-route="{{ route('index') }}"
                @if(!empty($category->media->first()))
                    style="background-image: url('{{ $category->media->first()->getPublicPath() }}');"
                @else
                    style="background-image: url('https://via.placeholder.com/150C/O https://placeholder.com/');"
                @endif>
                {{ $category->title }}
            </button>
        @endforeach
    </div>

    <div class="sub-categories-section" id="subCatSection">
        @if(!empty($categories) && $categories->isNotEmpty())

            @include('index::front.boxes.sub_categories', ['sub_categories' => $sub_categories, 'category' => $category])

        @endif
    </div>

    <div class="container-fluid">
        <div class="projects-heading">
            {{ trans('index::front.projects_heading') }}
        </div>
        <div class="card-columns portfolio-grid endless-pagination" id="portfolio">
            @if(!empty($sub_categories) && $sub_categories->isNotEmpty())

                @include('index::front.boxes.projects', ['projects' => $projects])

            @endif
        </div>
    </div>

    <div class="loading-container">
        <div class="preloader-chasing-squares">
            <div class="square"></div>
            <div class="square"></div>
            <div class="square"></div>
            <div class="square"></div>
        </div>
    </div>

@endsection