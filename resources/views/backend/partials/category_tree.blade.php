<ul class="list-unstyled">
    @foreach ($categories as $category)
        <li>
            <label class="aiz-checkbox">
                <input type="checkbox" value="{{ $category->id }}" name="category_ids[]">
                <span class="aiz-square-check"></span>
                <span>{{ $category->getTranslation('name') }}</span>
            </label>
            @if ($category->children_categories_count > 0)
                <ul class="list-unstyled ml-3">
                    @foreach ($category->childrenCategories as $childCategory)
                        <li>
                            <label class="aiz-checkbox">
                                <input type="checkbox" value="{{ $childCategory->id }}"
                                    name="category_ids[]">
                                <span class="aiz-square-check"></span>
                                <span>{{ $childCategory->getTranslation('name') }}</span>
                            </label>
                            @if (count($childCategory->childrenCategories) > 0)
                                <ul class="list-unstyled ml-3">
                                    @foreach ($childCategory->childrenCategories as $grandChildCategory)
                                        <li>
                                            <label class="aiz-checkbox">
                                                <input type="checkbox"
                                                    value="{{ $grandChildCategory->id }}"
                                                    name="category_ids[]">
                                                <span class="aiz-square-check"></span>
                                                <span>{{ $grandChildCategory->getTranslation('name') }}</span>
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </li>
    @endforeach
</ul>
