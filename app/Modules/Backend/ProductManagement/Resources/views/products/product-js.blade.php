<script>
    $('.another-variation').on('click', function() {
        var inputs = `<div class="input-group mb-4">
                        <select name="colors[]" class="form-control">
                            <option value="">-{{ __('Select Color') }}-</option>
                            @foreach ($colors as $key => $color)
                                <option value="{{ $color->id }}">{{ $color->name }}</option>
                            @endforeach
                        </select>
                        <select name="sizes[]" class="form-control">
                            <option value="">-{{ __('Select Size') }}-</option>
                            @foreach ($sizes as $key => $sz)
                                <option value="{{ $sz->id }}">{{ $sz->name }}</option>
                            @endforeach
                        </select>
                        <input type="number" class="form-control" placeholder="Enter quantity" name="quantities[]">
                        <button type="button" class="btn btn-danger input-group-text btn-sm text-light remove-row"><i class="fas fa-trash d-inline-block mt-1"></i></button>
                    </div>`;

        $('.variants').append(inputs);
    })

    $(document).on('click', '.remove-row', function() {
        $(this).parent('.input-group').remove();
    })
</script>
