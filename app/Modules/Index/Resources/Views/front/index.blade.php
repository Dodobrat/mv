@extends('layouts.app')
@section('content')


    <div class="main-categories-section">
        <div class="row justify-content-center align-items-center">

            @foreach($categories as $category)

                <div class="col-6">
                    <button class="main-category-btn"
                            data-slug="{{ $category->slug }}"
                            data-url="{{ route('categories.getSubCategories') }}"
                            data-route="{{ route('index') }}"
                            onclick="selectCat()">
                        {{ $category->title }}
                    </button>
                </div>

            @endforeach

        </div>
    </div>



    <div class="sub-categories-section" id="subCatSection">
        @include('index::front.boxes.sub_categories', compact($sub_categories,$category))
    </div>

    <div class="container-fluid">
        <div class="card-columns portfolio-grid endless-pagination" id="portfolio">

            @include('index::front.boxes.projects', compact($projects))

        </div>
    </div>


@endsection

@section('cats')

    <script>
        let cat = document.querySelectorAll('.main-category-btn' );
        let subCatsContainer = document.getElementById('subCatSection');

function selectCat(){
    cat.forEach(function (cat) {
        cat.addEventListener('click',function () {

            let catSlug = cat.dataset.slug;
            let catUrl = cat.dataset.url;
            let catRoute = cat.dataset.route;

            $.ajaxSetup({
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: catUrl,
                method: 'post',
                data: {
                    category_slug: catSlug,
                },
                beforeSend: function() {
                    // $(".load-container").show();
                },

                success: function(result) {
                    if (result.errors.length != 0) {
                        // $('.alert-danger').html('');
                        //
                        // $.each(result.errors, function (key, value) {
                        //
                        // });
                    } else {
                        window.history.pushState({},"", catRoute + '/' +catSlug);
                        // setTimeout('$(".load-container").hide()', 500);
                        subCatsContainer.innerHTML = result.new_blade;
                    }
                }
            });
        });
    });
}

    </script>

@endsection

@section('projects')

    <script>
        let subCat = document.querySelectorAll('.sub-category-btn' );
        let projectsContainer = document.getElementById('portfolio');


        function selectSubCat(){
            subCat.forEach(function (subCat) {
                subCat.addEventListener('click',function () {

                    let subCatSlug = subCat.dataset.slug;
                    let subCatUrl = subCat.dataset.url;
                    let subCatRoute = subCat.dataset.route;

                    $.ajaxSetup({
                        cache: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: subCatUrl,
                        method: 'post',
                        data: {
                            sub_category_slug: subCatSlug,
                        },
                        beforeSend: function() {
                            // $(".load-container").show();
                        },

                        success: function(result) {
                            if (result.errors.length != 0) {
                                // $('.alert-danger').html('');
                                //
                                // $.each(result.errors, function (key, value) {
                                //
                                // });
                            } else {
                                window.history.pushState({},"", subCatRoute + '/'+ subCatSlug);
                                // setTimeout('$(".load-container").hide()', 500);
                                projectsContainer.innerHTML = result.new_view;
                                $('.portfolio-grid > .portfolio-grid-item').hoverdir();
                            }
                        }
                    });
                });
            });
        }
        selectSubCat();

    </script>

@endsection