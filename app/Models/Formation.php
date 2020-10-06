<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Formation extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'formations';
    protected $appends = ['started, start_hour, start_minute, ended, end_hour, end_minute'];

    public function formateurs () {
        return $this->belongsToMany(Formateur::class, 'formateur_formations', 'formation_id', 'formateur_id');
    }

    public function etudiants () {
        return $this->belongsToMany(Etudiant::class, 'formation_etudiants', 'formation_id', 'etudiant_id');
    }

    public function category () {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function getStartedAttribute () {
        return Carbon::parse($this->start_date)->format('Y-m-d');
    }

    public function getStartHourAttribute () {
        return Carbon::parse($this->start_date)->format('H');
    }

    public function getStartMinuteAttribute () {
        return Carbon::parse($this->start_date)->format('i');
    }

    public function getEndedAttribute () {
        return Carbon::parse($this->end_date)->format('Y-m-d');
    }

    public function getEndHourAttribute () {
        return Carbon::parse($this->end_date)->format('H');
    }

    public function getEndMinuteAttribute () {
        return Carbon::parse($this->end_date)->format('i');
    }
}
