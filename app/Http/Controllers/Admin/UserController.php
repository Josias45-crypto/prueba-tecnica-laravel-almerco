<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Country;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::all();
        return view('admin.users.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        // Crear usuario con contraseña encriptada
        User::create([
            'identificador' => $request->identificador,
            'name' => $request->nombre, // Laravel usa 'name' por defecto
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'numero_celular' => $request->numero_celular,
            'cedula' => $request->cedula,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'city_id' => $request->city_id,
            'is_admin' => false, // Por defecto no es admin
        ]);

        return redirect()->route('admin.users.index')
                         ->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $countries = Country::all();
        $selectedCountry = $user->city->state->country;
        $states = $selectedCountry->states;
        $cities = $user->city->state->cities;
        
        return view('admin.users.edit', compact('user', 'countries', 'selectedCountry', 'states', 'cities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        // Preparar datos para actualizar
        $data = [
            'identificador' => $request->identificador,
            'nombre' => $request->nombre,
            'name' => $request->nombre,
            'numero_celular' => $request->numero_celular,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'city_id' => $request->city_id,
        ];

        // Si se proporciona nueva contraseña, encriptarla
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
                         ->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // No permitir eliminar al propio admin
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                           ->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
                         ->with('success', 'Usuario eliminado exitosamente.');
    }

    /**
     * DataTable: Obtener usuarios con filtros y paginación server-side
     */
    public function getData(Request $request)
    {
        $query = User::with('city.state.country');

        // Filtro general (búsqueda)
        if ($request->has('search') && $request->search['value']) {
            $search = $request->search['value'];
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('cedula', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('numero_celular', 'like', "%{$search}%");
            });
        }

        // Ordenamiento
        if ($request->has('order')) {
            $columns = ['id', 'identificador', 'nombre', 'email', 'cedula', 'numero_celular', 'fecha_nacimiento'];
            $orderColumn = $columns[$request->order[0]['column']] ?? 'id';
            $orderDirection = $request->order[0]['dir'] ?? 'asc';
            $query->orderBy($orderColumn, $orderDirection);
        }

        // Total de registros
        $totalRecords = User::count();
        $filteredRecords = $query->count();

        // Paginación
        $start = $request->start ?? 0;
        $length = $request->length ?? 10;
        $users = $query->skip($start)->take($length)->get();

        // Formatear datos para DataTable
        $data = $users->map(function($user) {
            return [
                'id' => $user->id,
                'identificador' => $user->identificador,
                'nombre' => $user->nombre,
                'email' => $user->email,
                'cedula' => $user->cedula,
                'numero_celular' => $user->numero_celular ?? 'N/A',
                'fecha_nacimiento' => $user->fecha_nacimiento->format('d/m/Y'),
                'edad' => $user->edad, // Accessor calculado en el modelo
                'ciudad' => $user->city->name ?? 'N/A',
                'estado' => $user->city->state->name ?? 'N/A',
                'pais' => $user->city->state->country->name ?? 'N/A',
            ];
        });

        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ]);
    }
}
