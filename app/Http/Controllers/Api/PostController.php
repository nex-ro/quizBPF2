<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Models\Post;
use App\Models\mahasiswa_nim;
use App\Http\Resources\PostResource;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = mahasiswa_nim::latest()->paginate(5);
        return new PostResource(true, 'List Data Posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama_mahasiswa_nim'     => 'required',
            'tempat_lahir'     => 'required',
            'tanggal_lahir'   => 'required',
            'noHp'     => 'required',
            'email'     => 'required',
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(),422);
        }


        $post = mahasiswa_nim::create([
            'nama_mahasiswa_nim'     => $request->nama_mahasiswa_nim,
            'tempat_lahir'     =>  $request->tempat_lahir,
            'tanggal_lahir'   => $request->tanggal_lahir,
            'noHp'     => $request->noHp,
            'email'     => $request->email,
        ]);

        return new PostResource(true, 'Data Post Berhasil Ditambahkan!', $post);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(mahasiswa_nim $post)
    {
        return new PostResource(true, 'Data Post Ditemukan!', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, mahasiswa_nim $post)
    {
        $validator = Validator::make($request->all(),[
            'nama_mahasiswa_nim'     => 'required',
            'tempat_lahir'     => 'required',
            'tanggal_lahir'   => 'required',
            'noHp'     => 'required',
            'email'     => 'required',
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(),422);
        }


            $post->update([
                'nama_mahasiswa_nim'     => $request->nama_mahasiswa_nim,
                'tempat_lahir'     =>  $request->tempat_lahir,
                'tanggal_lahir'   => $request->tanggal_lahir,
                'noHp'     => $request->noHp,
                'email'     => $request->email,
            ]);

        return new PostResource(true, 'Data Post Berhasil Diubah', $post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(mahasiswa_nim $post)
    {
        $post->delete();
        return new PostResource(true, 'Data Post Berhasil Dihapus', null);
    }
}
