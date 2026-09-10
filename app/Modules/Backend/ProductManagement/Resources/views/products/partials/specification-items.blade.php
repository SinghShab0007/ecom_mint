@php
    $rows = $rows ?? [];
    if (! is_array($rows)) {
        $rows = [];
    }
    $rows = array_values(array_filter($rows, fn ($r) => is_array($r)));
    if (count($rows) === 0) {
        $rows = array_fill(0, 8, ['label' => '', 'value' => '']);
    }
@endphp
<div class="specification-items-editor">
    <div class="card border bg-light mb-3">
        <div class="card-body py-2 px-3">
            <div class="row g-2 mb-0 fw-semibold small text-muted text-uppercase">
                <div class="col-md-5">{{ __('Label') }}</div>
                <div class="col-md-6">{{ __('Value') }}</div>
                <div class="col-md-1 text-end"></div>
            </div>
        </div>
    </div>
    <div id="specification-items-repeater">
        @foreach ($rows as $i => $row)
            <div class="row g-2 mb-2 align-items-center specification-item-row">
                <div class="col-md-5">
                    <input type="text"
                           name="specification_items[{{ $i }}][label]"
                           class="form-control"
                           placeholder="{{ __('e.g. Brand, Fabric, Fit Type') }}"
                           value="{{ old('specification_items.'.$i.'.label', $row['label'] ?? '') }}">
                </div>
                <div class="col-md-6">
                    <input type="text"
                           name="specification_items[{{ $i }}][value]"
                           class="form-control"
                           placeholder="{{ __('e.g. INDIAN TERRAIN, 100% Cotton') }}"
                           value="{{ old('specification_items.'.$i.'.value', $row['value'] ?? '') }}">
                </div>
                <div class="col-md-1 text-end">
                    <button type="button" class="btn btn-outline-danger btn-sm remove-spec-row" title="{{ __('Remove row') }}">&times;</button>
                </div>
            </div>
        @endforeach
    </div>
    <button type="button" class="btn btn-sm btn-primary mt-1" id="add-specification-row">
        <i class="fas fa-plus"></i> {{ __('Add row') }}
    </button>
</div>

<script>
(function () {
    var specRowIndex = {{ count($rows) }};
    var repeater = document.getElementById('specification-items-repeater');
    if (!repeater) return;
    var addBtn = document.getElementById('add-specification-row');

    function rowTemplate(index) {
        return '<div class="row g-2 mb-2 align-items-center specification-item-row">' +
            '<div class="col-md-5">' +
            '<input type="text" name="specification_items[' + index + '][label]" class="form-control" placeholder="{{ e(__('e.g. Brand, Fabric, Fit Type')) }}">' +
            '</div>' +
            '<div class="col-md-6">' +
            '<input type="text" name="specification_items[' + index + '][value]" class="form-control" placeholder="{{ e(__('e.g. INDIAN TERRAIN, 100% Cotton')) }}">' +
            '</div>' +
            '<div class="col-md-1 text-end">' +
            '<button type="button" class="btn btn-outline-danger btn-sm remove-spec-row" title="{{ e(__('Remove row')) }}">&times;</button>' +
            '</div>' +
            '</div>';
    }

    if (addBtn) {
        addBtn.addEventListener('click', function () {
            repeater.insertAdjacentHTML('beforeend', rowTemplate(specRowIndex++));
        });
    }

    repeater.addEventListener('click', function (e) {
        if (!e.target.matches('.remove-spec-row')) return;
        var row = e.target.closest('.specification-item-row');
        if (!row || !repeater.contains(row)) return;
        if (repeater.querySelectorAll('.specification-item-row').length <= 1) {
            row.querySelectorAll('input').forEach(function (inp) { inp.value = ''; });
            return;
        }
        row.remove();
    });
})();
</script>
