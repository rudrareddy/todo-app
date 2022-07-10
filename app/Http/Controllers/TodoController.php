<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TodoList;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Session;
use Exception;
use Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $todo_all = TodoList::orderBy('id','desc')->get();
      $todo_completed = TodoList::where('status','=',1)->orderBy('id','desc')->get();
      $todo_incompleted = TodoList::where('status','=',0)->orderBy('id','desc')->get();
      return view('todo.index',compact('todo_all','todo_completed','todo_incompleted'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
          $data = Arr::except($request->all(), ['_token']);
          $data['status']=0;
          $create = TodoList::create($data);
          if($create){
               Session::flash('success', 'Successfully created!');
               return redirect('todo');
           }else{
              Session::flash('error', 'Something went wrong!');
               return redirect('todo');
           }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
      try{
        $todo = TodoList::where('uuid',$uuid)->firstOrFail();
        $data['status'] =1;
        $update=TodoList::where('uuid','=',$uuid)->update($data);
        if($update){
             Session::flash('success', 'Successfully updated!');
             return redirect('todo');
         }else{
            Session::flash('error', 'Something went wrong!');
             return redirect('todo');
         }
      }catch(ModelNotFoundException $e){
         return back()->withError('Todo is not found this ' .$uuid)->withInput();
      }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
      try{
         $todo = TodoList::where('uuid',$uuid)->firstOrFail();
         $todo = TodoList::where('uuid','=',$uuid)->delete();
         Session::flash('success', 'Successfully deleted!');
         return redirect('todo');
      }catch (ModelNotFoundException $exception) {
         //dd($exception->getMessage());
        return back()->withError('Todo not found by ID ' .$uuid)->withInput();
      }
    }
}
