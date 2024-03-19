<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Choice extends Model
{
    /** The table associated with the model.
     *
     * @var string
     */
    protected $table = 'choices';
    public function question():HasMany{
        return $this->hasMany(Question::class);
    }
}
