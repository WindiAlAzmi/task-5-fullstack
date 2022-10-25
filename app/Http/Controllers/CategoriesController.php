<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categoriesData = Categories::get();
        return view('dashboard.categories.index', compact('categoriesData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoriesData = Categories::get();

        return view('dashboard.categories.create', compact('categoriesData'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newData = $request->all();
        $cekData = Validator::make($newData, [
            'name' => 'required',
            'user_id' => 'required',
        ]);
      
        $newCategories = new Categories();
        $newCategories->name = $newData['name'];
        $newCategories->user_id = Auth::user()->id;
        $newCategories->save();


        return redirect('/dashboard/categories');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categoriesData = Categories::findorfail($id);
        return view('dashboard.categories.view', compact('categoriesData'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categoriesData = Categories::findorfail($id);

        return view('dashboard.categories.edit', compact('categoriesData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $newData = $request->all();
        $cekData = Validator::make($newData, [
            'name' => 'required',
            'user_id' => 'required',
        ]);
            $newCategories = Categories::findorfail($id);
            $newCategories->name = $newData['name'];
            $newCategories->user_id = Auth::user()->id;
            $newCategories->save();

    
        return redirect('/dashboard/categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categoriesData = Categories::where('id', $id)->get();

        $categoriesData->each->delete();
        return redirect('/dashboard/categories');
    }
}
