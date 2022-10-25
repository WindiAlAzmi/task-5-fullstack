<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoriesRequest;
use App\Http\Resources\CategoriesResource;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Categories::paginate(4);
        // return response()->json($data);
        $result = CategoriesResource::collection($data);
        return $this->sendResponse($result, "successful get categories");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoriesRequest $request)
    {
        $data = new CategoriesResource(Categories::create($request->validated()));
        return $this->sendResponse($data, 'succesfull create new data');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cekData = Categories::find($id);
        if(!$cekData){
            abort(404, 'object not found');

        }
        $result = new CategoriesResource($cekData);
        return $this->sendResponse($result, 'successful get category');
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

       $postEdit = $request->all();
       $cekPostEdit = Validator::make($postEdit, [
            'name' => 'required',
            'user_id' => 'required',
        ]);
        if ($cekPostEdit->fails()) {
            return $this->sendError('Validasi eror.', $cekPostEdit->errors());
        }

        $CategoriesNew = Categories::FindOrFail($id);
        $CategoriesNew->name = $postEdit['name'];
        $CategoriesNew->user_id = $postEdit['user_id'];
        $CategoriesNew->save();

        $result = new CategoriesResource($CategoriesNew);
        return $this->sendResponse($result, 'succeful update category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $CategoriesCek = Categories::FindOrFail($id);
        if($CategoriesCek->delete()){
        $result = new CategoriesResource($CategoriesCek);
        return $this->sendResponse($result, 'succeful delete category');
        }
    }
}
