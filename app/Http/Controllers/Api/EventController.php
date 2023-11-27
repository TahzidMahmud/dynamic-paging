<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventCollection;
use Illuminate\Http\Request;
use App\Models\Event;
use DB;
class EventController extends Controller
{
    public function gallery_data()
    {
        return new EventCollection(Event::where('featured', 1)->orderBy('featured','desc')->paginate(6));
    }
}
