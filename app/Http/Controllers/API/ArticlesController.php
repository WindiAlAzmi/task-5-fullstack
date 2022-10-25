<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Articles;
use Illuminate\Http\Request;
use App\Http\Resources\ArticlesResource;
use Illuminate\Support\Facades\Validator;


class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = Articles::paginate(4);
        $result = ArticlesResource::collection($data);
        return $this->sendResponse($result, "successful get articles");
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
            'image' => 'required',
            'user_id' => 'required',
            'category_id' => 'required',
        ]);
   
        if($cekData->fails()){
          return $this->sendError('Validasi eror.', $cekData->errors());
        }
   
        $articleNew = Articles::create($dataNew);
         $result = new ArticlesResource($articleNew);
        return $this->sendResponse($result, 'successful create articles');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Articles  $articles
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cekData = Articles::find($id);
        if(!$cekData){
            abort(404, 'object not found');

        }
        $result = new ArticlesResource($cekData);
        return $this->sendResponse($result, 'successful get articles');
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
        $postEdit = $request->all();
       $cekPostEdit = Validator::make($postEdit, [
            'title' => 'required',
            'content' => 'required',
            'image' => 'required',
            'user_id' => 'required',
            'category_id' => 'required',
        ]);
        if ($cekPostEdit->fails()) {
            return $this->sendError('Validasi eror.', $cekPostEdit->errors());
        }

        $CategoriesNew = Articles::FindOrFail($id);
        $CategoriesNew->title= $postEdit['title'];
        $CategoriesNew->content = $postEdit['content'];
        $CategoriesNew->image = $postEdit['image'];
        $CategoriesNew->user_id = $postEdit['user_id'];
        $CategoriesNew->category_id = $postEdit['category_id'];

        $CategoriesNew->save();

        $result = new ArticlesResource($CategoriesNew);
        return $this->sendResponse($result, 'successful update articles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Articles  $articles
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteData = Articles::FindOrFail($id);
        if($deleteData->delete()){
        $result = new ArticlesResource($deleteData);
        return $this->sendResponse($result, 'successful delete articles');
    }
}
}