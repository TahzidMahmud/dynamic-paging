<?php

namespace App\Observers;

use App\Models\Role;
use App\Models\User;
use App\Models\Staff;
use App\Models\StaffActionLog;

class StaffActionObserver
{
    /**
     * Handle the staff "created" event.
     *
     * @param  \App\Staff  $staff
     * @return void
     */
    public function created(Staff $staff)
    {
        dd('create');
        StaffActionLog::create([
            'staff_id' => $staff->id,
            'user_id' => auth()->user()->id,
            'role_id' => $staff->role_id,
            'staff_name' => $staff->user->name,
            'user_name' => auth()->user()->name,
            'role_name' => $staff->role->name,
            'action' => 'Created',
        ]);
    }

    /**
     * Handle the staff "updated" event.
     *
     * @param  \App\Staff  $staff
     * @return void
     */
    public function updated(Staff $staff)
    {
        dd('Update');
        StaffActionLog::create([
            'staff_id' => $staff->id,
            'user_id' => auth()->user()->id,
            'role_id' => $staff->role_id,
            'action' => 'Updated',
            'staff_name' => $staff->user->name,
            'user_name' => auth()->user()->name,
            'role_name' => $staff->role->name,
        ]);
    }

    /**
     * Handle the staff "deleted" event.
     *
     * @param  \App\Staff  $staff
     * @return void
     */
    public function deleted(Staff $staff)
    {
        dd('delete');

        $abc = $staff->getOriginal('id');
        $stat=StaffActionLog::where('staff_id', $abc)->first();
        $user=User::find($staff->getOriginal('user_id'));
        $role=Role::find($staff->getOriginal('role_id'));

        StaffActionLog::create([
            'staff_id' => $staff->getOriginal('id'),
            'user_id' => auth()->user()->id,
            'role_id' => $staff->getOriginal('role_id'),
            'action' => 'Deleted',
            'staff_name' => $stat->staff_name??'',
            'user_name' => auth()->user()->name,
            'role_name' => $role->name??'',
        ]);
    }

    /**
     * Handle the staff "restored" event.
     *
     * @param  \App\Staff  $staff
     * @return void
     */
    public function restored(Staff $staff)
    {

    }

    /**
     * Handle the staff "force deleted" event.
     *
     * @param  \App\Staff  $staff
     * @return void
     */
    public function forceDeleted(Staff $staff)
    {
        StaffActionLog::create([
            'staff_id' => $staff->id,
            'user_id' => auth()->user()->id,
            'role_id' => $staff->role_id,
            'action' => 'Force Deleted',
            'staff_name' => $staff->user->name,
            'user_name' => auth()->user()->name,
            'role_name' => $staff->role->name,
        ]);
    }
}
