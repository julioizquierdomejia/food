<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Area;
use App\Models\Stall;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $usuarios = User::all();
        $areas = Area::all();
        $cargos = Stall::all();

        //insertamos nombres de lso atributos
        foreach ($usuarios as $key => $usuario) {
            foreach ($areas as $key => $area) {
                if($usuario->area_id == $area->id){
                    $usuario['area'] = $area->name;
                }
            }

            foreach ($cargos as $key => $cargo) {
                if($usuario->stall_id == $cargo->id){
                    $usuario['cargo'] = $cargo->name;
                }
            }
        }

    
        return view('admin.users.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $areas = Area::where('status', 1)->get();
        $cargos = Stall::where('status', 1)->get();

        return view('admin.users.create', compact('areas', 'cargos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'name'  =>  'required|regex:/^[\pL\s\-]+$/u',
            'email'  =>  'required|unique:users|email',
            'dni'  =>  'required|unique:users|max:8|min:8',
            'phone'  =>  'required|unique:users|max:9|min:9',
            'role'  =>  'required',
            'area_id'  =>  'required',
            'stall_id'  =>  'required',
            
        ]);

        $usuario = new User();

        if($request->hasFile("image")){

            //obteneos el nombre de la imagen con GetclientOriginalName()
            $nombre = Str::random(10) . '_' . $request->file('image')->getClientOriginalName();

            //Creamos una ruta apuntando al Storage, y a que carpeta irá, tiene que existitr la carpeta
            $ruta = storage_path() . '/app/public/images/perfil/' . $nombre;


            //en una sola linea, creamos la imagen, la redimensionamos y la grabamos en la ruta que hemos crado
            Image::make($request->file('image'))->resize(250, 250)->save($ruta);

            //Grabamos en la base de datos toda la ruta de la imagen
            $usuario->uri_image = '/storage/images/perfil/';
            $usuario->name_image = $nombre;

        }


        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->dni = $request->dni;
        $usuario->phone = $request->phone;
        $usuario->role = $request->role;
        $usuario->area_id = $request->area_id;
        $usuario->stall_id = $request->stall_id;
        $usuario->password = bcrypt($request->phone);
        
        $usuario->save();

        

        return redirect('/admin/users');

        

        /*
        $this->validate($request, User::rules());

        $data = $request->all();
        $data['password'] = bcrypt(request('password'));

        User::create($data);
        */

        return back()->withSuccess(trans('app.success_store'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $item = User::findOrFail($id);
        $areas = Area::where('status', 1)->get();
        $cargos = Stall::where('status', 1)->get();

        return view('admin.users.edit', compact('item', 'areas', 'cargos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        //$this->validate($request, User::rules(true, $id));
        $request->validate([
            'name'  =>  'required|regex:/^[\pL\s\-]+$/u',
            'email'  =>  'required|email',
            'dni'  =>  'required|max:8|min:8',
            'phone'  =>  'required|max:9|min:9',
            'role'  =>  'required',
            'area_id'  =>  'required',
            'stall_id'  =>  'required',
            
        ]);

        $item = User::findOrFail($id);

        //$data = $request->except('password', 'avatar');

        /*
        if (request('password')) {
            $data['password'] = bcrypt(request('password'));
        }
        */

        if($request->hasFile("image")){

            //obteneos el nombre de la imagen con GetclientOriginalName()
            $nombre = Str::random(10) . '_' . $request->file('image')->getClientOriginalName();

            //Creamos una ruta apuntando al Storage, y a que carpeta irá, tiene que existitr la carpeta
            $ruta = storage_path() . '/app/public/images/perfil/' . $nombre;


            //en una sola linea, creamos la imagen, la redimensionamos y la grabamos en la ruta que hemos crado
            Image::make($request->file('image'))->resize(250, 250)->save($ruta);

            //Grabamos en la base de datos toda la ruta de la imagen
            $item->uri_image = '/storage/images/perfil/';
            $item->name_image = $nombre;

        }

        $item->name = $request->name;
        $item->email = $request->email;
        $item->dni = $request->dni;
        $item->phone = $request->phone;
        $item->role = $request->role;
        $item->area_id = $request->area_id;
        $item->stall_id = $request->stall_id;
        $item->password = bcrypt($request->phone);
        
        $item->update();


        return redirect()->route(ADMIN . '.users.index')->withSuccess(trans('app.success_update'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $usuario = User::find($id);
        $nombre = $usuario->name;
        $usuario->delete();

        return $nombre.' ha sido Eliminado';
        
    }


    public function updateStatus(Request $request){

        $usuario = User::find($request->id);

        $usuario->update([
            'status' => $request->status,
        ]);
    }

}
