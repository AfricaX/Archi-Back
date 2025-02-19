<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projects;

class ProjectsController
{
    /**
     * Create new project
     * http://localhost:8000/api/projects/
     */

     public function create(Request $request){
        $user = Auth::user();

        $today = now()->format('Y-m-d');

        $validator = validate($request->all(), [
            'user_id' => 'required|exists:users,id',
            'lot_size' => 'required| numeric | max:1000',
            'floors' => 'required | numeric | max:50',
            'finish_type' => 'required | max:30',
            'image' => 'sometimes | images | mimes:jpeg,png,jpg,gif,svg|max:2048'

        ]);

        if($validator->fails()){
            return response()->json([
                'ok' => false,
                'message' => 'Project Creation Failed',
                'errors' => $validator->errors()
            ], 400);
        }

        $project = Projects::create($validator->validated());
        return response()->json([
            'ok' => true,
            'message' => 'Project Creation Success',
            'data' => $project
        ],200);
     }

     /**
      * Display listing of projects
      * http://localhost:8000/api/projects/
      */

      public function index(){
        return response()-json([
            'ok' => true,
            'message' => 'Retrieved Successfully',
            'date' => Projects::all()
        ],200);
      }

      /**
       * Update 
       * http://localhost:8000/api/projects/{project}
       */

       public function update(Request $request, Projects $project){
        $validator = validator($request->all(),[
            'user_id' => 'required|exists:users,id',
            'lot_size' => 'required| numeric | max:1000',
            'floors' => 'required | numeric | max:50',
            'finish_type' => 'required | max:30',
            'image' => 'sometimes | images | mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if($validator->fails()){
            return response()->json([
                'ok' => false,
                'message' => 'Project Update Failed',
                'errors' => $validator->errors()
            ], 400);
        }

        $project->update($validator->validated());
        return response()->json([
            'ok' => true,
            'message' => 'Project Updated Success',
            'date' => $project
        ], 200);
       }

       /**
        * Delete Projects
        * http://localhost:8000/api/projects/{project}
       */

       public function destroy(Projects $project){
        $project->delete();
        return response()->json([
            'ok'=> true,
            'message' => 'Project Deleted Successfully',
            'date' => $project
        ], 200);
       }
}
