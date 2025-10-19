<?php

namespace App\Http\Controllers;

use App\Services\ConfigService;
use Illuminate\Http\Request;

class TestControl extends Controller
{

    //Constructor que manda a llamar el servicio
    protected $parkServis;

    public function __construct(ConfigService $parkServis)
    {
        $this->parkServis = $parkServis;
    }

    //Funcionalidad de prueba

    public function index()
    {
        $parque = $this->parkServis->getParks();
        //prueba con postman
        dd($parque);

        //Modificar para front
        
        // return view('')->with('message', 'Hello from TestControl!');
    }

    public function store (Request $request)
    {
        // Lógica para almacenar datos
        $data = $request->validate([
             'park_name'=> 'required|string|max:100',
            'park_abbreviation'=> 'required|string|max:10',
            'park_img_url'=> 'required|string',
            'park_address'=> 'required|string|max:150',
            'park_city' => 'required|string',
            'park_state' => 'required|string|max:100',
            'park_zip_code' => 'required|integer',
            'park_latitude' => 'required|numeric',
            'park_longitude'=> 'required|numeric'
        ]);

        //Llammamos el servicio para guardar los datos
        $parque = $this->parkServis->createPark($data);

        dd($parque);

        if($request->wantsJson() || $request->isJson() || $request->expectsJson()){
            return response()->json([
                'message' => 'Park created successfully',
                'data' => $parque
            ], 201);
        }


        //Fronnt tiene que modificar aqui
        if($parque){
            return redirect()->back()->with('success', 'Park created successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to create park');

        }

}

}
