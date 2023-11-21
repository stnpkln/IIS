<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatingModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rating';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = ['user_id', 'post_id'];

     /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    public $timestamps = false;

        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'post_id',
        'rating_type'
    ];
}


