<?php

namespace App\Models;

use App\Models\Role;
use App\Models\User;
use App\Models\Staff;
use Illuminate\Database\Eloquent\Model;

class StaffActionLog extends Model
{
    protected $fillable = ['id', 'staff_id', 'user_id', 'role_id', 'action', 'user_name', 'staff_name', 'role_name'];
    protected $table = 'staff_action_logs';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
