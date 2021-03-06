<?php

namespace App\Http\Controllers;

use App\Core\DAL\CategoryRepository;
use App\Core\Helpers\Utilities;
use App\Core\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private CategoryRepository $CategoryRepository;
    public function __construct()
    {
        $this->CategoryRepository = new CategoryRepository(new Category());
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
        $response = $this->CategoryRepository->index($request->take, $request->skip);
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
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        
        if(array_key_exists('image', $data))
        {
            if(!is_null($data['image']))
            {
                $data['image'] = Utilities::upload($data['image'], 'Category');
            }
        }
        $response = $this->CategoryRepository->createModel(new Category($data));
        return Utilities::wrap($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = $this->CategoryRepository->show($id);
        return Utilities::wrap($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        
        if(array_key_exists('image', $data))
        {
            if(!is_null($data['image']))
            {
                $data['image'] = Utilities::upload($data['image'], 'Category');
            }
        }
        $response = $this->CategoryRepository->update($id, $data);
        return Utilities::wrap($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = $this->CategoryRepository->delete($id);
        return Utilities::wrap($response);
    }

}
