<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use Illuminate\Validation\Rule;
use Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class EventController extends Controller
{
    public function index()
    {    
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('event-index')) {
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
        return view('event.index',  compact('events', 'approve_permission', 'all_permission'));
    }   
    public function create(){
        return view('event.create');
    }

    public function store(Request $request)
    {
        $data = [ 
            'meeting'     => $request->input('meeting'),
            'start_time'=> $request->input('start_time'),           
            'user_id'     => Auth::id(),
        ];        
        // echo json_encode($data);
        Event::create($data);
        return redirect()->back()->with('create_message', "New Event created successfully");
    }
    public function edit($id)
    {
        
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('event-edit')) {         
            $event_data = Event::where('id', $id)->first();
            return view('event.edit', compact('event_data'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }
    public function update(Request $request, $id)
    {
       
        $event_data = Event::find($id);
        $data = [
                'meeting'     => $request->input('meeting'),
                'start_time'=> $request->input('start_time'),           
                'user_id'     => Auth::id(),
        ];
        $event_data->update($data);
        return redirect()->back()->with('message', "Event updated successfully");
    }

    public function deleteBySelection(Request $request)
    {
        $event_id = $request['eventIdArray'];
        foreach ($event_id as $id) {
            $event_data = Event::find($id);
            $event_data->delete();
        }
        return 'Event deleted successfully!';
    }

    public function destroy($id)
    {
        Event::find($id)->delete();
        return redirect()->back()->with('not_prmitted', "Event deleted successfully");
    }
}
