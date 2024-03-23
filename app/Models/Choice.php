<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Choice extends Model
{
    /** The table associated with the model.
     *
     * @var string
     */
    protected $table = 'choices';
    protected $fillable = ['name', 'question_id', 'is_correct'];
    public function question():BelongsTo{
        return $this->belongsTo(Question::class);
    }
}
