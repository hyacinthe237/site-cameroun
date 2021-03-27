<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'pages';

    public function user () {
        return $this->belongsTo(User::class, 'last_updated_by');
    }

    public function commune () {
        return $this->belongsTo(Commune::class, 'commune_id');
    }

    public function region () {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function departement () {
        return $this->belongsTo(Departement::class, 'departement_id');
    }
}
