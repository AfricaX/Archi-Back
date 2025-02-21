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
        $validator = validator($request->all(), [
            'user_id' => 'required|exists:users,id',
            'lot_size' => 'required| numeric | max:1000',
            'floors' => 'required | numeric | max:50',
            'finish_type' => 'required | max:30',
            'image' => 'sometimes | mimes:jpeg,png,jpg,gif,svg|max:2048'

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
        return response()->json([
            'ok' => true,
            'message' => 'Retrieved Successfully',
            'data' => Projects::all()
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
            'image' => 'sometimes | mimes:jpeg,png,jpg,gif,svg|max:2048'
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

       /**
        * Recent 10 Projects    
        *
        */

        public function recents(){
            return response()->json([
                'ok' => true,
                'message' => 'Recents Retrieved Successfully',
                'data' => Projects::latest()->take(10)->get()
            ], 200);
        }

        /**
         * Dynamic Filter
         */

         public function filter(Request $request){

            $query = Projects::query();

            if ($request->filled('finish_type')){
                $query->where('finish_type', $request->finish_type);
            }

            if ($request->filled('floors')){
                $query->where('floors', $request->floors);
            }

            if ($request->filled('lot_size')){
                $query->where('lot_size', $request->lot_size);
            }

            $projects = $query->latest()->get();

            return response()->json([
                'ok'=> true,
                'message' => 'Filtered projects retrieved successfully',
                'date' => $projects
            ], 200);
         }
}
