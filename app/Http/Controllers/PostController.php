<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\mahasiswa_nim;

class PostController extends Controller
{
    public function index (){
        $posts = mahasiswa_nim::latest()->paginate(5);
        return view('post.list', compact('posts'));
    }

}
