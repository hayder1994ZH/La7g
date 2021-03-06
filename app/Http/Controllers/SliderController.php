<?php

namespace App\Http\Controllers;

use App\Core\DAL\SliderRepository;
use App\Core\Helpers\Utilities;
use App\Core\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    private SliderRepository $SliderRepository;
    public function __construct()
    {
        $this->SliderRepository = new SliderRepository(new Slider());
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
        $response = $this->SliderRepository->index($request->take, $request->skip);
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
            'title' => 'required|max:255',
            'image' => 'required|mimes:jpg,bmp,png',
            'redirect_to' => 'nullable|max:255',
        ]);
        $response = $this->SliderRepository->store($data);
        return Utilities::wrap($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = $this->SliderRepository->getById($id);
        return Utilities::wrap($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'image' => 'nullable|mimes:jpg,bmp,png',
            'redirect_to' => 'nullable|max:255',
        ]);
        $response = $this->SliderRepository->edit($id, $data);
        return Utilities::wrap($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = $this->SliderRepository->delete($id);
        return Utilities::wrap($response);
    }
}
