<?php

namespace App\Http\Controllers;

use App\Core\DAL\SubCategoryRepository;
use App\Core\Helpers\Utilities;
use App\Core\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    private SubCategoryRepository $SubCategoryRepository;
    public function __construct()
    {
        $this->SubCategoryRepository = new SubCategoryRepository(new SubCategory());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'skip' => 'Integer',
            'take' => 'required|Integer',
        ]);
        $response = $this->SubCategoryRepository->index($request->take, $request->skip);
        return Utilities::wrap($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'category_id' => 'required|exists:categories,id',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if(array_key_exists('image', $data))
        {
            if(!is_null($data['image']))
            {
                $data['image'] = Utilities::upload($data['image'], 'SubCategory');
            }
        }
        $response = $this->SubCategoryRepository->createModel(new SubCategory($data));
        return Utilities::wrap($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = $this->SubCategoryRepository->show($id);
        return Utilities::wrap($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'category_id' => 'required|exists:categories,id',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        
        if(array_key_exists('image', $data))
        {
            if(!is_null($data['image']))
            {
                $data['image'] = Utilities::upload($data['image'], 'SubCategory');
            }
        }
        $response = $this->SubCategoryRepository->update($id, $data);
        return Utilities::wrap($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = $this->SubCategoryRepository->delete($id);
        return Utilities::wrap($response);
    }

}
