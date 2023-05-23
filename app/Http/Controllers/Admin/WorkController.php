<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class WorkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $works= Work::all();

        return view('admin/works/index', compact('works'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/works/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validation($request);

        $formData = $request->all();

        $work = new Work();

        $work->title = $formData['title'];
        $work->description = $formData['description'];
        $work->image = $formData['image'];
        $work->date = $formData['date'];
        $work->git_url = $formData['git_url'];
        $work->slug = Str::slug($work->title, '-');

        $work->save();

        return redirect()->route('admin.works.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Work  $work
     * @return \Illuminate\Http\Response
     */
    public function show(Work $work)
    {
        return view('admin/works/show', compact('work'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Work  $work
     * @return \Illuminate\Http\Response
     */
    public function edit(Work $work)
    {
        return view('admin/works/edit', compact('work'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Work  $work
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Work $work)
    {
        $formData= $request->all();

        $work->update($formData);

        $work->save();

        return redirect()->route('admin.works.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Work  $work
     * @return \Illuminate\Http\Response
     */
    public function destroy(Work $work)
    {
        $work->delete();

        return redirect()->route('admin.works.index');
    }

    private function validation($request){
        

        $formData = $request->all();

        $validator = Validator::make($formData,

        [
            'title'=> 'required|min:2|max:50|unique:works,title',
            'description'=> 'required|min:2',
            'image'=> 'required|min:2',
            'date'=> 'nullable',
            'git_url'=> 'required|min:2',
        ],
        
        [
            'title.required'=> 'Questo campo non può essere lascaito vuoto',
            'title.min'=> 'Questo campo deve avere minimo 2 caratter',
            'title.max'=> 'Questo campo può avere massimo 50 caratteri',
            'title.unique'=> 'Questo campo è già esistente',
            'description.required'=> 'Questo campo non può essere lascaito vuoto',
            'description.min'=> 'Questo campo deve avere minimo 2 caratter',
            'image.required'=> 'Questo campo non può essere lascaito vuoto',
            'image.min'=> 'Questo campo deve avere minimo 2 caratter',
            'git_url.required'=> 'Questo campo non può essere lascaito vuoto',
            'git_url.min'=> 'Questo campo deve avere minimo 2 caratter',
            
            
            
        ])->validate();

        return $validator;
    }
}
