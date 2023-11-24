<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\Request;

class IdeaController extends Controller
{
    public function show(Idea $idea){
        return view("ideas.show", [
            "idea" => $idea
        ]);
        // you can simply do
        // return view("ideas.show", compact("idea"));
        // to get the same result
    }

    public function store(){

        request()->validate([
            "content" => "required|min:5|max:240"
        ]);

        $idea = Idea::create(
            [
                "content" => request()->get("content", "")
            ]
        );

        return redirect()->route("dashboard")->with("success","Idea was created successfully.");
    }

    public function destroy(Idea $idea){

        $idea->delete();

        return redirect()->route("dashboard")->with("success","Idea was deleted successfully.");
    }

    public function edit(Idea $idea){
        $editing = true; //this will enable us use the same blade to do showing and editing
        return view("ideas.show", compact("idea", "editing"));
    }

    public function update(Idea $idea){

        request()->validate([
            "content" => "required|min:5|max:240"
        ]);

        $idea->content = request()->get("content", "");
        $idea->save();
        return redirect()->route("ideas.show", $idea->id)->with("success","Idea was updated successfully.");
    }
}
