@foreach($sub_categories as $sub_category)
    <li class="sub_category">
        <button class="sub-category-btn">
            {{ $sub_category->title }}
        </button>
    </li>
@endforeach