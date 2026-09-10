
    <ul class="maan-chart-point-list">
        <li class="maan-chart-title fs red">
            <span>{{$best_selling_category['category_name'][0]??''}}</span>
            @if(!empty($best_selling_category['category_count']) && isset($best_selling_category['category_count'][0]))<p>{{$best_selling_category['category_count'][0]}} ({{round(($best_selling_category['category_count'][0]*100)/array_sum($best_selling_category['category_count']))}}%)</p>
            @endif
        </li>

        <li class="maan-chart-title fs blue">
            <span>{{$best_selling_category['category_name'][1]??''}}</span>
            @if(!empty($best_selling_category['category_count']) && isset($best_selling_category['category_count'][1]))<p>{{$best_selling_category['category_count'][1]}} ({{round(($best_selling_category['category_count'][1]*100)/array_sum($best_selling_category['category_count']))}}%)</p>
            @endif
        </li>

        <li class="maan-chart-title fs green">
            <span>{{$best_selling_category['category_name'][2]??''}}</span>
            @if(!empty($best_selling_category['category_count']) && isset($best_selling_category['category_count'][2]))<p>{{$best_selling_category['category_count'][2]}} ({{round(($best_selling_category['category_count'][2]*100)/array_sum($best_selling_category['category_count']))}}%)</p>
            @endif
        </li>

        <li class="maan-chart-title fs">
            <span>{{$best_selling_category['category_name'][3]??''}}</span>
            @if(!empty($best_selling_category['category_count']) && isset($best_selling_category['category_count'][3]))<p>{{$best_selling_category['category_count'][3]}} ({{round(($best_selling_category['category_count'][3]*100)/array_sum($best_selling_category['category_count']))}}%)</p>
            @endif
        </li>

    </ul>

