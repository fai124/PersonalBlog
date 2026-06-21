<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    /**
     * Поля для массового заполнения
     */
    protected $fillable = [
        'title',
        'content',
        'user_id',
    ];

    /**
     * Связь: статья принадлежит пользователю
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
