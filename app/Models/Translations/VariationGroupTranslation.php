<?php

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Model;

class VariationGroupTranslations extends Model{
    protected $table = "variation_group_translations";

    public $timestamps = false;
    protected $fillable = ['title','description'];
}