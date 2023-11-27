<?php

namespace App\Observers;

use App\Models\User;
// use App\Models\Seller;
use App\Models\UserActionLog;
use Auth;

class UserObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function created(User $user)
    {
        UserActionLog::create([
            'user_name'=>$user->name,
            'user_id'=>$user->id,
            'performed_by_id'=>0,
            'performed_by_name'=>'System',
            'user_type'=>'customer',
            'user_new_type'=>'customer',
            'action'=>'Create'
        ]);
        return 1;
    }

    /**
     * Handle the user "updated" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        // dd($user);
        if($user->user_type=='admin'){
            // dd($user);
            return redirect('/logout');
        }else{
            $auth_user = Auth::user();
            $user_data = User::findOrFail($user->id);
            // $seller_data = Seller::where('user_id',$user->id)->first();
            // dd($seller_data->verification_status);
            $user_log = UserActionLog::where('user_id',$user_data->id)->latest()->first();
            if($user_log == null){
                return 1;
            }else{
                UserActionLog::create([
                    'user_name'=> $user->name,
                    'user_id' => $user->id,
                    'performed_by_id'=> $auth_user?$auth_user->id:'0',
                    'performed_by_name'=> $auth_user?$auth_user->name:'system',
                    'user_type'=>$user_log->user_new_type,
                    // 'user_new_type'=>$seller_data ? ($seller_data->verification_status == 1  ? $user_data->user_type : 'customer') : 'customer',
                    'user_new_type'=> 'customer',
                    'action'=>'Update'
                ]);
                return 1;

            }
            return 1;
        }


    }

    /**
     * Handle the user "deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        // dd($user);
        $auth_user = Auth::user();
        // $user_data = User::findOrFail($user->id);
        $user_log = UserActionLog::where('user_id',$user->id)->latest()->first();
        UserActionLog::create([
            'user_name'=>$user->name,
            'user_id'=>$user->id,
            'performed_by_id'=>$auth_user?$auth_user->id:'0',
            'performed_by_name'=> $auth_user?$auth_user->name:'system',
            'user_type'=>$user_log?$user_log->user_type:'customer',
            'user_new_type'=>$user_log?$user_log->user_new_type:'customer',
            'action'=>'Delete'
        ]);
        return 1;
    }

    /**
     * Handle the user "restored" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
