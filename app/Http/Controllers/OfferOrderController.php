<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOfferOrderRequest;
use App\Http\Requests\UpdateOfferOrderRequest;
use App\Models\OfferOrder;

class OfferOrderController extends Controller
{
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
     * @param  \App\Http\Requests\StoreOfferOrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOfferOrderRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OfferOrder  $offerOrder
     * @return \Illuminate\Http\Response
     */
    public function show(OfferOrder $offerOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OfferOrder  $offerOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(OfferOrder $offerOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOfferOrderRequest  $request
     * @param  \App\Models\OfferOrder  $offerOrder
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOfferOrderRequest $request, OfferOrder $offerOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OfferOrder  $offerOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(OfferOrder $offerOrder)
    {
        //
    }
}
