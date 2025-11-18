<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       return Category::where('user_id', $request->user()->id)->get(); 

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
        $data = $request->validate();
        $data['user_id'] = $request->user()->id;

        $category = Category::create($data);
         return response()->json (['message'=>'category created successfully', 'category'=> $category],201);

    

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function show( Resquest $request,category $category)

    {
        if ($request->user_id !== $category->user_id){
            return response()->json (['message' =>' unauthoried access'],401);
        
        }
        return $category;
        
         
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, category $category)
    {
        if($request->user_id !== $category->user_id){
            return response()->json (['message'=>'unauthoried access'],401);

        }
        $category->update($request->validated());
        return $category;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy( Request $request, category $category)
    {
        if($request->user_id !== $category->user_id){
            return response()->json (['message'=>'unauthoried access'],401);

                }

            $category->delete();
            return response()->json(['message'=> 'Category deleted successfully'],204);

    }
}
