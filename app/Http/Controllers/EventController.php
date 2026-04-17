<?php

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class EventController extends Controller
{
    //
    public function show()
    {
        return view('event-detail');
    }

    public function checkout(){
        return view('checkout');
    }
}
