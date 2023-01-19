<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuoteRequest;
use App\Http\Requests\UpdateQuoteRequest;
use App\Http\Resources\QuoteResource;
use App\Models\Quote;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return QuoteResource::collection(Quote::paginate(5));   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuoteRequest $request)
    {
        // TIDAK CLEAN
        // if ($validate) {
        //     $quote = Quote::create($validate);
        //     return new QuoteResource($quote);
        // }
        
        // clean pakai request
        return new QuoteResource(Quote::create($request->validated()));
        // return response()->json('hello');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Quote $quote)
    {
        return new QuoteResource($quote);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuoteRequest $request, Quote $quote)
    {
        // clean code
        // 1. cara pertama
        $quote->update($request->validated());
        return new QuoteResource($quote);

        // 2. cara lebih clean
        // return new QuoteResource(tap($quote->update($request->validated())));
    }

    /**
     * Remove the specified resource from storage.\
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
        // 1. cara pertama kurang sip

        // $quote = Quote::find($id);

        // if ($quote) {

        //     $quote->delete();

        //     return response()->json(["message" => "Quote Deleted"], 204);
        // }else{
        //     return response()->json(["message" => "Quote Not Found"], 404);
        // }

        // 2. cara kedua kurang sip
        // $quote = Quote::findOrFail($id)->delete();
        // return response()->json(["message" => "Quote Deleted"],204);
    // }

    public function destroy(Quote $quote){
        $quote->delete();
        return response()->noContent();
    }
}
