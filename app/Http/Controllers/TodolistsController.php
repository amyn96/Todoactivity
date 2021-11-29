<?php

namespace App\Http\Controllers;

use App\Models\task;
use App\Models\Todolists;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\Response;

class TodolistsController extends Controller
{
    // Show list of list
    public function index()
    {
        //$this->can('view', $todolists);
        // $todolists = Todolists::all();
        $todolists = Todolists::where('user_id', Auth::id())->get();

        return view('dashboard', compact('todolists'));
    }

    // create and save list to database
    public function store(Request $request)
    {
        $data = $request->validate([
            'content' => 'required'
        ]);

        Todolists::create([
            'content' => $request->input('content'),
            'user_id' => Auth::id()
        ]);
        return back();
    }

    // delete list and task
    public function destroy(Request $request)
    {
        //$todolist = new Todolists;
        $list_id = explode('/', $request->url());
        $listdel = Todolists::findOrFail((int)$list_id[4]);
        $listTask = task::where('list_id', (int)$list_id[4])->get();
        //dd($listdel->content);
        if(!$listTask->isEmpty()) {
            foreach($listTask as $l) {
                $l->delete();
            }
        }
        
        
        $listdel->delete();

        return back()->with('delete', $listdel->content.' has been DELETED');
    }

    // log out
    public function logout()
    {
        return redirect('welcome');
    }

    //view edit
    public function listedit(Request $request)
    {
        $list_id = explode('/', $request->url());
        $todolists = Todolists::where('id', (int)$list_id[4])->get();
        //dd($todolists[0]);
        return view('editlistview', compact('todolists'));  
    }

    //edit list
    public function edit(Request $request, Todolists $list)
    {
        $data = $request->validate([
            'content' => 'required'
        ]);
        $list_id = explode('/', $request->url());
        $listedit = Todolists::findOrFail((int)$list_id[4]);
        //$listTask = Todolists::where('id', (int)$list_id[4]);
        $listedit->content = $data['content'];
        //dd($request->user()->can('update', $list));

        if ($request->user()->cannot('update', $list)) {
            abort(403);
        }else{
            $listedit->save();
        }
        //$listedit->save();
        return redirect('dashboard')->with('message', 'List updated SUCCESSFULLY');
    }

}
