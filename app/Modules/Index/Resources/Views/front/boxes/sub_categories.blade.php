<div class="sub-categories">
    @foreach($sub_categories as $sub_category)

            <button class="sub-category-btn"
                    data-slug="{{ $sub_category->slug }}"
                    data-url="{{ route('categories.getProjects') }}"
                    data-route="{{ route('index',['slug' => $category->slug]) }}"
                    data-aos="zoom-in"
                    >
                {{ $sub_category->title }}
            </button>

    @endforeach
</div>




