<?php

namespace App;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class Information extends Model 
{
    use SoftDeletes, Auditable;

    public $table = 'information';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static $searchable = [
        'name',
        'descrition',
        'owner',
        'constraints',
    ];

    protected $fillable = [
        'name',
        'descrition',
        'owner',
        'administrator',
        'storage',
        'security_need_c',
        'security_need_i',
        'security_need_a',
        'security_need_t',
        'sensitivity',
        'constraints',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function informationsDatabases()
    {
        return $this->belongsToMany(Database::class);
    }

    public function processes()
    {
        return $this->belongsToMany(Process::class);
    }
}
