<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $ofertas = Offer::where('status', 1);
        return view('admin.offer.index', compact('ofertas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return view('admin.offer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        //validaciones
        $request->validate([
            'name'  =>  'required',
            'cost_us'  =>  'required',
            'cant'  =>  'required',
        ]);

        $offer = new Offer();
        $offer->name = $request->name;
        $offer->cost_us = $request->cost_us;
        $offer->cant = $request->cant;

        $offer->save();

        return redirect('/admin/offer');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function show(Offer $offer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function edit(Offer $offer)
    {
        //
        $oferta = $offer;
        return view('admin.offer.edit', compact('oferta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Offer $offer)
    {
        //
        //validaciones
        $request->validate([
            'name'  =>  'required',
            'cost_us'  =>  'required',
            'cant'  =>  'required',
        ]);

        $offer->name = $request->name;
        $offer->cost_us = $request->cost_us;
        $offer->cant = $request->cant;

        $offer->update();

        return redirect('/admin/offer');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Offer $offer)
    {
        //
        $offer->delete();
        return redirect('/admin/offer');
    }
}
