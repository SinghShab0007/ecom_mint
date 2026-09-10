<canvas id="timeline-chart"></canvas>
<div class="maan-chart-color-point-wrp">
    <div class="color-items blue">
        <p>{{__('Selected Month')}}</p>
    </div>
    <div class="color-items red">
        <p>{{__('Previous Month')}}</p>
    </div>
</div>

@push('js')
    <script>
        (function ($) {

            "use strict";

            $(document).ready(function () {

            });
        })(jQuery);

        let height = document.querySelector('.dashboard-linecahrt-wrap');
        height.style.height = '200px';
        height.style.overflow = 'hidden';

        let height2 = document.querySelector('#timeline-chart');
        height2.style.height = '160px';
        height2.style.width = '100%';
    </script>
@endpush
