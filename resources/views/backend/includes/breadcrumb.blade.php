<!-- Breadcrumb-->
<div class="card no-print">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{url('/admin')}}">{{ __('Dashboard') }} </a>
        </li>

        <?php $link = url('/admin'); ?>
        @for($i = 1; $i <= count(Request::segments()); $i++)
            @if(Request::segment($i) =='admin')

            @else
                <pre>  >  </pre>
                @if($i < count(Request::segments()) & $i > 0)
                    <?php $link .= "/" . Request::segment($i); ?>
                    <a class="align-middle"
                       href="<?= $link ?>">{{ ucwords(str_replace('_',' ',Request::segment($i)))}}</a>
                @else {{ucwords(str_replace('_',' ',Request::segment($i))) }}
                @endif
            @endif
        @endfor

    </ol>
</div>
<!-- End Breadcrumb-->
