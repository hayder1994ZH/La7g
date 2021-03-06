<?php

namespace App\Http\Controllers;

use App\Core\DAL\RatingRepository;
use App\Core\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    private RatingRepository $RatingRepository;
    private $user_id;
    public function __construct()
    {
        $this->RatingRepository = new RatingRepository(new Rating());
        $this->user_id = auth()->user()->id;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        $data = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'rate' => 'required|digits_between:1,10'
        ]);
        $data['user_id'] = $this->user_id;
        return $this->RatingRepository->rate($data);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function show(rating $rating)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, rating $rating)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function destroy(rating $rating)
    {
        //
    }
}
