<?php

namespace App\Http\Controllers;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function tasks(Request $request){



        if(!$request->completed){
            $tasks = Task::where('user_id', $request->user()->id)->get();
            return response()->json([
                $tasks
            ], 200);
        }

        else if($request->completed == 'true' || $request->completed == 'false'){
            $tasks = Task::where('user_id', $request->user()->id)->where('completed', $request->completed)->get();
            return response()->json([
                $tasks
            ], 200);
        }

        else{
            return response()->json([
                'page not found'
            ], 404);
        }
    }

    public function addTask(Request $request){


        $request->validate([
            'body' => 'required'
        ]);

        $task = Task::create([
            'body' => $request->body,
            'user_id'=>$request->user()->id,
        ]);

        if(!$request->body){
            return response()->json([
                "success"=> false,
                "message"=> "Tous les champs sont obligatoire"
            ], 400);
        }

        return response()->json([
            $task
        ], 201);
    }

    public function deleteTask(Request $request, $id){


        $task = Task::find($id);

        if(!$task){
            return response()->json([
                "message"=> "Cette tache n'existe pas"
            ], 404);
        }

        if($request->user()->id != $task->user_id){
            return response()->json([
                "message"=> "Vous n'êtes pas authorisé a supprimer cette tache"
            ], 403);
        }

        $task_deleted = Task::where('id', $id)->delete();

        return response()->json([
            "success"=>true
        ], 200);
    }

    public function updateTask(Request $request, $id){


        $task = Task::find($id);
        if(!$task){
            return response()->json([
                "message"=> "Cette tache n'existe pas"
            ], 404);
        }

        if($request->user()->id != $task->user_id){
            return response()->json([
                "message"=> "Vous n'êtes pas authorisé a modifier cette tache"
            ], 403);
        }

        $request->validate([
            'body' => 'required'
        ]);

        $task_updated = Task::where('id', $id)->update([
            'body'=> $request->body
        ]);
        return response()->json([
            "success"=>true
        ], 200);
    }

    public function checkTask(Request $request, $id){


        $task = Task::find($id);
        if(!$task){
            return response()->json([
                "message"=> "Cette tache n'existe pas"
            ], 404);
        }

        if($request->user()->id != $task->user_id){
            return response()->json([
                "message"=> "Vous n'êtes pas authorisé a remplir cette tache"
            ], 403);
        }

        $task_updated = Task::where('id', $id)->update([
            'completed'=> true
        ]);

        return response()->json([
            "success"=>true
        ], 200);
    }

}
