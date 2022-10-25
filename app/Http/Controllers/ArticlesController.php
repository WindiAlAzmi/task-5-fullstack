<?php

namespace App\Http\Controllers;

use App\Models\Articles;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;



class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articlesData = Articles::get();

        $categoriesData = Categories::get();
        return view('dashboard.articles.index', compact('categoriesData', 'articlesData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoriesData = Categories::get();

        return view('dashboard.articles.create', compact('categoriesData'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dataNew = $request->all();
        $cekData = Validator::make($dataNew, [
            'title' => 'required',
            'content' => 'required',
            'image' => 'sometimes|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'user_id' => 'required',
            'category_id' => 'required',
        ]);
        $gambar = $request->file('image');
        $namaGambar= time() . '-' . $gambar->getClientOriginalName();
        $gambar->move(public_path() . '/upload/', $namaGambar);
        $newArticle = new Articles();
        $newArticle->title = $dataNew['title'];
        $newArticle->content = $dataNew['content'];
        $newArticle->image = $namaGambar;
        $newArticle->user_id = Auth::user()->id;
        $newArticle->category_id = $dataNew['category_id'];
        $newArticle->save();


        return redirect('/dashboard/articles');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Articles  $articles
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $articlesData = Articles::findorfail($id);
       
        return view('dashboard.articles.view', compact('articlesData'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Articles  $articles
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $articlesData = Articles::findorfail($id);
        $categoriesData = Categories::get();

        return view('dashboard.articles.edit', compact('articlesData','categoriesData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Articles  $articles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $Articles = Articles::findorfail($id);
        $dataNew = $request->all();
        $cekDataNew = Validator::make($dataNew, [
            'title' => 'required',
            'content' => 'required',
            'image' => 'sometimes|image|mimes:jpg,png,jpeg,gif,svg|max:2048',  
            'user_id' => 'required',
            'category_id' => 'required',
        ]);
        $gambar = $request->file('image');
        $namaGambar = time() . '-' . $gambar->getClientOriginalName();
        $gambar->move(public_path() . '/upload/', $namaGambar);


        $newArticle = Articles::findorfail($id);
        $newArticle->title = $dataNew['title'];
        $newArticle->content = $dataNew['content'];
        $newArticle->image = $namaGambar;
        $newArticle->user_id = Auth::user()->id;
        $newArticle->category_id = $dataNew['category_id'];
        $newArticle->save();

        
        return redirect('/dashboard/articles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Articles  $articles
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $articlesData = Articles::where('id', $id)->get();

        $articlesData->each->delete();
        return redirect('/dashboard/articles');
    }
}
