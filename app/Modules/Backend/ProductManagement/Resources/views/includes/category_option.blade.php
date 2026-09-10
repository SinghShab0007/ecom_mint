@foreach ($categories as $index => $cat)
    <option value="{{ $cat->id }}" @if (isset($product) && $cat->id == $product->category_id || $cat->id == old('category_id')) selected @endif>
        @for ($i = 0; $i <= $child; $i++)
            {{ '>' }}
        @endfor

        {{ $cat->name }}
    </option>
    @if (isset($cat->children))
        @include('productmanagement::includes.category_option', [
            'child' => $child + $child,
            'categories' => $cat->children,
        ])
    @endif
@endforeach
