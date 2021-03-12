<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupCommand extends Model
{
    protected $table = 'group_commands';
    protected $fillable = ['name', 'status'];
}
