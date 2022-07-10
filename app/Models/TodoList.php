<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Uuid;
class TodoList extends Model
{
    use HasFactory;

    protected $fillable = ['uuid','slug','todo_name','description','status'];

    public static function boot()
   {
       parent::boot();

       static::creating(function($model) {
           $model->slug = Str::slug($model->todo_name);

           $latestSlug =
               static::whereRaw("slug = '$model->slug' or slug LIKE '$model->slug-%'")
                  ->latest('id')
                  ->value('slug');
           if ($latestSlug) {
               $pieces = explode('-', $latestSlug);

               $number = intval(end($pieces));

               $model->slug .= '-' . ($number + 1);
           }
           $uuid=Uuid::generate()->string;
           if(TodoList::where('uuid',$uuid)->exists()){
              $this->generateUniqueCode();
           }
           $model->uuid = $uuid;
       });
   }
}
