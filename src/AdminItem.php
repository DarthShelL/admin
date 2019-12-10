<?php

namespace DarthShelL\Admin;

use Illuminate\Database\Eloquent\Model;

class AdminItem extends Model
{
    protected $table = 'admin_items';

    protected $fillable = [
        'label',
        'parent',
        'type',
        'route',
        'method',
        'controller',
        'action',
        'visible'
    ];


}
