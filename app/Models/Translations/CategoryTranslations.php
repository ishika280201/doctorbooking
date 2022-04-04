<?php

namespace App\Models\Translations;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class CategoryTranslations extends Model{

    protected $table = 'categories_translations';

    public $translationalModel = Category::class;

    public function category(){
        return $this->hasMany(Category::class,'id','cat_id');
    }

    public $timestamps = false;

    protected $fillable = ['title','description'];
}