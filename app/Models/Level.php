<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Level extends Model
{
    /** The table associated with the model.
     *
     * @var string
     */
    protected $table = 'levels';
    public function questions():HasMany{
        return $this->hasMany(Question::class);
    }
}
