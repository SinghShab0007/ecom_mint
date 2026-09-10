<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WebAppearance extends Model
{
    use HasFactory;

    protected $table = 'web_appearances';
    protected $fillable=[
        'website_name','logo','favicon','backend_logo','meta_title','meta_desc','keywords','website_base_color','website_base_hover_color',
        'cookies_agreement_desc','is_show_cookies_agreement','hotline_number','get_in_touch','facebook_link',
        'twitter_link','pinterest_link','instagram_link','currency_id','city','country','post_code','email','about_us','base_currency_id','linkdin_link','youtube_link'


    ];
    public function country(): BelongsTo {
        return $this->belongsTo(Country::class,'country');
    }

    public function currency(): BelongsTo {
        return $this->belongsTo(Currency::class,'currency_id');
    }
}
