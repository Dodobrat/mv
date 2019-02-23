<div class="sub-categories">
        <h1 class="sub-categories-heading">
                {{ trans('index::front.sub_category_select') }}
        </h1>
    @foreach($sub_categories as $sub_category)
        <button class="sub-category-btn"
                data-slug="{{ $sub_category->slug }}"
                data-url="{{ route('categories.getProjects') }}"
                data-route="{{ route('index') }}"
                >
            {{ $sub_category->title }}
        </button>
    @endforeach
</div>




