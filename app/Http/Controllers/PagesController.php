<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Genre;
use App\Models\Publisher;
use App\Models\Book;
//use Illuminate\Auth\Access\Gate;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function about(){
        return view('about');
    }
}
