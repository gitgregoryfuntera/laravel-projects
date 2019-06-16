<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $projects = new Project;
        return $projects->userProjects();
    }

    public function store()
    {
        $attributes = $this->validateProject();

        $attributes['user_id'] = auth()->user()->id;

        Project::create($attributes);

        return $this->jsonResponse($attributes, 'Success');
    }

    public function show(Project $project)
    {
        return $project;
    }

    public function update(Project $project)
    {
        $userID = $project->user_id;
        $authID = auth()->user()->id;

        if ($userID === $authID) {
            $project->update($this->validateProject());
            return $this->jsonResponse($project, $userID);
        } else {
            return $this->errorResponse('You are not authorized!');
        }

    }


    public function destroy(Project $project)
    {
        $userID = $project->user_id;
        $authID = auth()->user()->id;
        
        if ($userID === $authID) {
            $project->delete();
            return $this->jsonResponse($project, 'Success');
        } else {
            return $this->errorResponse('You are not authorized!');
        }

    }

    public function validateProject() {
        return request()->validate([
            'title' =>  'required|min:3',
            'description' => 'required|min:3',
        ]);
    }

    public function jsonResponse($data, $message) {
        return response()->json([
            'data' => $data,
            'message' => $message
        ]);
    }

    public function errorResponse($message) {
        return response()->json([
            'message' => $message
        ], 401);
    }
}
