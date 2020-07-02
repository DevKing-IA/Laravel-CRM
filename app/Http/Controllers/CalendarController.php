<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use Illuminate\Validation\Rule;
use Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CalendarController extends Controller
{
    public function index()
    {    
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('calendar-index')) {
            $approve_permission = true;
            $events = Event::orderBy('id', 'desc')->get();
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';
        }
        else {
            $approve_permission = false;
            $events = Event::where('user_id', Auth::id())->orderBy('id', 'desc')->get();
        }
        return view('calendar.index',  compact('events', 'approve_permission', 'all_permission'));
    }
}
