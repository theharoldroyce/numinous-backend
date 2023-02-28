<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Events;
use  Illuminate\Support\Facades\Validator;

class EventController extends Controller
{

    public function index()
    {
        $events = Events::all();
        return response()->json(['events' =>$events],200);
    }

    public function show($id)
    {
        $events = Events::find($id);
        if($events)
        {
            return response()->json(['events' =>$events],200);
        }
        else
        {
            return response()->json(['message' =>'Sorry No Record Found'],404);
        }
    }

    public function store(Request $request)
    {
        $request-> validate([
         'name' =>'required|max:191',
         'location' =>'required|max:191',
         'dates' =>'required|max:191',
        ]);

        $events = new Events;
        $events -> name = $request -> name;
        $events -> location = $request -> location;
        $events -> dates = $request -> dates;
        $events -> save();
        return response()->json(['message'=> 'Event Successfuly Added'],200);
    }

    public function update(Request $request,$id)
    {
        $request-> validate([
            'name' =>'required|max:191',
            'location' =>'required|max:191',
            'dates' =>'required|max:191',
           ]);

           $events = Events::find($id);
           if($events)
           {
            $events -> name = $request -> name;
            $events -> location = $request -> location;
            $events -> dates = $request -> dates;
            $events -> update();
            return response()->json(['message'=> 'Event Successfuly Updated'],200);
           }
           else
           {
            return response()->json(['message'=> 'NO Event Found'],404);
           }
    }

    public function destroy($id)
    {
        $events = Events::find($id);
        if($events)
        {
            $events ->delete();
            return response()->json(['message'=> 'Event Deleted'],200);
        }
        else
        {
            return response()->json(['message'=> 'Event Not Found'],404);
        }
    }
}
