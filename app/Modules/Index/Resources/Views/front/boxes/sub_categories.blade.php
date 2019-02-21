<ul class="sub-categories">
    @foreach($sub_categories as $sub_category)
        <li class="sub_category">
            <button class="sub-category-btn"
                    data-slug="{{ $sub_category->slug }}"
                    data-url="{{ route('categories.getProjects') }}"
                    data-route="{{ route('index',['slug' => $category->slug]) }}"
                    onclick="selectSubCat()">
                {{ $sub_category->title }}
            </button>
        </li>
    @endforeach
</ul>




