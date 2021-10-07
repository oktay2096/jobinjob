<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\User;
use \App\Models\Task;
use Hash;
use Session;
class AdminController extends Controller
{
    public function info(Request $req)
    {
       $date = date('Y-m-d');
       if($req->date != "")
       {
            $date = $req->date;
       }
       $user_id  =Session::get('Login')->id;
       $task = Task::where('user_id', $user_id)->where('date', $date)->select('task', 'admin')->first();
       $last_day = date('Y-m-d', strtotime("+1 day", strtotime($date)));
       $before_day = date('Y-m-d', strtotime("-1 day", strtotime($date)));
       $data = ['task'=>$task, 'user'=>Session::get('Login')->name,'last_day'=>$last_day,'before_day'=>$before_day,'now_date'=>$date];
      
       return response()->json($data, 200);

    
    }
    public function userlist()
    {
        $user = User::select('id as value', 'name', 'email', 'role', 'username')->get();
        return response()->json($user, 200);
    }
    public function tasklist()
    {
        $all_taks = Task::join('users', 'users.id', '=', 'task.user_id')->select('task.id as taskid', 'users.name', 'task.task','task.created_at', 'task.date', 'task.admin')->orderby('task.id', 'DESC')->get();
        return response()->json($all_taks, 200);
    }
    public function userdelete(Request $req)
    {
        $user = User::findorfail($req->id);
        if($user->role == 1)
        {
            $data = ['status'=>false, 'message'=>'Admin Not Deleted'];
            return response()->json($data, 200);
        }
        $user->delete();

        $user_all = User::select('id as value', 'name', 'email', 'role', 'username')->get();
        return response()->json($user_all, 200);
    }
    public function useradd(Request $req)
    {
       

        if(User::where('email', $req->email)->count() > 0)
        {
            $data = ['status'=>false, 'message'=>'Email Available'];
            return response()->json($data, 200);
        }
        if(User::where('username', $req->username)->count() > 0)
        {
            $data = ['status'=>false, 'message'=>'Username Available'];
            return response()->json($data, 200);
        }
        $user = new User();
        $user->email = $req->email;
        $user->password = Hash::make($req->password);
        $user->role = $req->role;
        $user->name = $req->name;
        $user->username = $req->username;

        $user->save();

        $user_all = User::select('id as value', 'name', 'email', 'role', 'username')->get();
        return response()->json($user_all, 200);

    }
    public function taskdelete(Request $req)
    {
        try
        {
            $task = Task::findorfail($req->id);
            $task->delete();
            $all_taks = $this->tasklist();
            return response()->json($all_taks->original, 200);
        }
        catch(Excaption $e)
        {
            return response()->json($e, 200);
        }
    }
    public function taskadd(Request $req)
    {
        try
        {
            if(Task::where('user_id', $req->user)->where('date', $req->date)->count() > 0)
            {
                $data = ['status'=>false, 'error'=>'This user already has a task'];
                return response()->json($data, 200);
            }
            else
            {
                $task = new Task();
                $task->date= $req->date;
                $task->user_id = $req->user;
                $task->task = $req->task;
                $task->admin = Session::get('Login')->name;
                $task->save();
    
                $all_taks = $this->tasklist();
                return response()->json($all_taks->original, 200);
            }
           
        }
        catch(Excaption $e)
        {
            return response()->json($e, 200);
        }
       
    }
}
