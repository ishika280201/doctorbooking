<?php

namespace App\Models\Translations;

use App\Models\Variation;
use Illuminate\Database\Eloquent\Model;

class VariationTranslations extends Model
{
    protected $table = "variation_translations";

    public $translationModel = Variation::class;

    public function category(){
        return $this->hasMany(Variation::class,'id','cat_id');
    }

    public $timestamps = false;
    
    protected $fillable = ['title','description'];
}