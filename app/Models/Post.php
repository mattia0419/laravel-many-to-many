<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Type;
class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'slug', 'type_id'];

    public function type(){
        return $this->belongsTo(Type::class);
    }

    public function getTypeBadge(){
        return $this->type ? "<span class='badge' style='background-color:{$this->type->color}'>{$this->type->name}</span>" : "Without type";
             
    }
}
