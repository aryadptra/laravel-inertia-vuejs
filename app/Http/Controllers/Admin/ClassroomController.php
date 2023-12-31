<?php

namespace App\Http\Controllers\Admin;

use App\Models\Classroom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get classrooms
        $classrooms = Classroom::when(request()->q, function ($classrooms) {
            $classrooms = $classrooms->where('title', 'like', '%' . request()->q . '%');
        })->latest()->paginate(5);

        //append query string to pagination links
        $classrooms->appends([request()->all]);

        //render with inertia
        return Inertia::render('Admin/Classrooms/Index', [
            'classrooms' => $classrooms,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //render with inertia
        return Inertia::render('Admin/Classrooms/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate request
        $request->validate([
            'title' => 'required|string|unique:classrooms'
        ], [
            'title.required' => 'Kolom kelas harus diisi!',
            'title.unique' => 'Kelas sudah ada!',
        ]);

        //create classroom
        Classroom::create([
            'title' => $request->title,
        ]);

        //redirect
        return to_route('admin.classrooms.index')->with('success', 'Data berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //get classroom
        $classroom = Classroom::findOrFail($id);

        //render with inertia
        return Inertia::render('Admin/Classrooms/Edit', [
            'classroom' => $classroom,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Classroom $classroom)
    {
        //validate request
        $request->validate([
            'title' => 'required|string|unique:classrooms,title,' . $classroom->id,
        ]);

        //update classroom
        $classroom->update([
            'title' => $request->title,
        ]);

        //redirect
        return redirect()->route('admin.classrooms.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //get classroom
        $classroom = Classroom::findOrFail($id);

        //delete classroom
        $classroom->forceDelete();

        //redirect
        return to_route('admin.classrooms.index')->with('success', 'Data berhasil dihapus!');
    }
}
