<?php

namespace App\Http\Controllers\Qvm;

use App\Http\Requests\StoreOfferTypeRequest;
use App\Http\Requests\UpdateOfferTypeRequest;
use App\Models\OfferType;
use App\Http\Controllers\Controller;


class OfferTypeController extends Controller
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
     * @param  \App\Http\Requests\StoreOfferTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOfferTypeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OfferType  $offerType
     * @return \Illuminate\Http\Response
     */
    public function show(OfferType $offerType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OfferType  $offerType
     * @return \Illuminate\Http\Response
     */
    public function edit(OfferType $offerType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOfferTypeRequest  $request
     * @param  \App\Models\OfferType  $offerType
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOfferTypeRequest $request, OfferType $offerType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OfferType  $offerType
     * @return \Illuminate\Http\Response
     */
    public function destroy(OfferType $offerType)
    {
        //
    }
}
