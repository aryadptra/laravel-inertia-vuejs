<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lesson;
use Inertia\Inertia;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get lesson
        $lessons = Lesson::when(request()->q, function ($lessons) {
            $lessons = $lessons->where('title', 'like', '%' . request()->q . '%');
        })->latest()->paginate(10);

        // append query string to pagination links
        $lessons->appends(request()->all());

        // render with inertia
        return Inertia::render('Admin/Lessons/Index', [
            'lessons' => $lessons
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // render with inertia
        return Inertia::render('Admin/Lessons/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate request
        $request->validate([
            'title' => 'required|string|unique:lessons',
        ], [
            'title.unique' => 'Judul sudah ada, silahkan gunakan yang lain!',
            'title.required' => 'Judul harus diisi!'
        ]);

        // create lesson
        Lesson::create([
            'title' => $request->title,
        ]);

        // redirect back
        return to_route('admin.lessons.index')->with('success', 'Data berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // get lesson
        $lesson = Lesson::findOrFail($id);

        // render with inertia
        return Inertia::render('Admin/Lessons/Edit', [
            'lesson' => $lesson
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // defining lesson
        $id = Lesson::findOrFail($id);

        //validate request
        $request->validate([
            'title' => 'required|string|unique:lessons,title,' . $id->title,
        ]);

        //update lesson
        $id->update([
            'title' => $request->title,
        ]);

        // return redirect with inertia
        return to_route('admin.lessons.index')->with('success', 'Data berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // defining lesson
        $id = Lesson::findOrFail($id);

        // delete lesson
        $id->delete();

        // return redirect with inertia
        return to_route('admin.lessons.index')->with('success', 'Data berhasil dihapus!');
    }
}
