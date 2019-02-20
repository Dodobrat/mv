@extends('layouts.app')
@section('content')

    <div class="main-categories-section">
        <div class="row justify-content-center align-items-center">

            @foreach($categories as $category)

                <div class="col-6">
                    <button class="main-category-btn">
                        {{ $category->title }}
                    </button>
                </div>

            @endforeach

        </div>
    </div>

    <div class="sub-categories-section">
        <ul class="sub-categories">

            @include('index::front.boxes.sub_categories', compact($sub_categories))

        </ul>
    </div>

    <div class="container-fluid">
        <div class="card-columns portfolio-grid endless-pagination">

            @include('index::front.boxes.projects', compact($projects))

        </div>
    </div>


@endsection