<?php

namespace App\Http\Controllers;

use App\Models\task;
use App\Models\Todolists;
use Illuminate\Http\Request;

class taskController extends Controller
{
    //show list of task
    public function task(Request $request)
    {
        $user = $request->user();
        $task = task::where('list_id', request()->list_id)->get();
        $list = Todolists::where('id', request()->list_id)->get();
        //dd($list);
        //session()->put('List',['id'=>$list->id,'content'=>$todolist->content]);

        if($list[0]->user_id != $user->id){
            return redirect('dashboard')->with('delete', 'You are not permitted to view this data.');
        }else{
            return view('task', compact('task','list'));
        }
        
    }


    //create and save task to database
    public function store(Request $request, $id)
    {

        $list_id = explode('/', $request->url());

        $data = $request->validate([
            'content' => 'required'
        ]);

        $savedata = [
            'content' => $request->content,
            'list_id' => (int)$list_id[4]
        ];

        task::create($savedata);

        return back();
    }

    //view task
    public function index()
    {
        $todolists = task::all();
        return view('dashboard', compact('task'));
    }

    //delete task
    public function destroy(Request $request)
    {
        $list_id = explode('/', $request->url());
        $taskdel = task::findOrFail((int)$list_id[4]);
        $taskdel->delete();
        return back()->with('delete', $taskdel->content.' has been DELETED');
    }

    //log out
    public function logout()
    {
        return redirect('welcome');
    }

    //view edit
    public function taskedit(Request $request)
    {
        $task_id = explode('/', $request->url());
        $todolists = task::where('id', (int)$task_id[4])->get();
        //dd($todolists[0]);
        return view('edittaskview', compact('todolists'));  
    }

    //edit list
    public function edit(Request $request)
    {
        $task = new task;
        $data = $request->validate([
            'content' => 'required'
        ]);
        $task_id = explode('/', $request->url());
        $taskedit = task::findOrFail((int)$task_id[4]);
        $listTask = Todolists::where('id', $taskedit->list_id)->get(); //-->search database for list
        $taskedit->content = $data['content'];
        //dd($data);
        if ($request->user()->cannot('update', $task)) {
            abort(403);
        }else{
            $taskedit->save();
        }
        //$taskedit->save();
        return redirect('dashboard')->with('message', 'Task from "'.$listTask[0]->content.'" list updated SUCCESSFULLY'); //-->redirect to dashboard page with update message
    }
}
