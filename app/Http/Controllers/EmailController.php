<?php

namespace App\Http\Controllers;

use App\Models\Email;
use Illuminate\Http\Request;
use App\Jobs\SendEmailJob;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Si es admin, ver todos los emails; si es usuario normal, solo los suyos
        if (auth()->user()->is_admin) {
            return view('admin.emails.index');
        }
        
        return view('emails.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('emails.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'asunto' => 'required|string|max:255',
            'destinatario' => 'required|email',
            'cuerpo' => 'required|string',
        ], [
            'asunto.required' => 'El asunto es obligatorio.',
            'destinatario.required' => 'El destinatario es obligatorio.',
            'destinatario.email' => 'Debe ser un email válido.',
            'cuerpo.required' => 'El cuerpo del mensaje es obligatorio.',
        ]);

        // Crear el email
        $email = Email::create([
            'user_id' => auth()->id(),
            'asunto' => $request->asunto,
            'destinatario' => $request->destinatario,
            'cuerpo' => $request->cuerpo,
            'estado' => 'no_enviado',
        ]);

        // Encolar el email para envío
        SendEmailJob::dispatch($email);

        return redirect()->route('emails.index')
                         ->with('success', 'Email creado y encolado para envío.');
    }

    /**
     * DataTable: Obtener emails del usuario o todos (si es admin)
     */
    public function getData(Request $request)
    {
        $query = Email::with('user');

        // Si no es admin, solo mostrar sus emails
        if (!auth()->user()->is_admin) {
            $query->where('user_id', auth()->id());
        }

        // Filtro general
        if ($request->has('search') && $request->search['value']) {
            $search = $request->search['value'];
            $query->where(function($q) use ($search) {
                $q->where('asunto', 'like', "%{$search}%")
                  ->orWhere('destinatario', 'like', "%{$search}%")
                  ->orWhere('estado', 'like', "%{$search}%");
            });
        }

        // Ordenamiento
        if ($request->has('order')) {
            $columns = ['id', 'asunto', 'destinatario', 'estado', 'created_at'];
            $orderColumn = $columns[$request->order[0]['column']] ?? 'id';
            $orderDirection = $request->order[0]['dir'] ?? 'desc';
            $query->orderBy($orderColumn, $orderDirection);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Total de registros
        $totalRecords = auth()->user()->is_admin ? Email::count() : Email::where('user_id', auth()->id())->count();
        $filteredRecords = $query->count();

        // Paginación
        $start = $request->start ?? 0;
        $length = $request->length ?? 10;
        $emails = $query->skip($start)->take($length)->get();

        // Formatear datos para DataTable
        $data = $emails->map(function($email) {
            $row = [
                'id' => $email->id,
                'asunto' => $email->asunto,
                'destinatario' => $email->destinatario,
                'estado' => $email->estado == 'enviado' 
                    ? '<span class="badge bg-success">Enviado</span>' 
                    : '<span class="badge bg-warning text-dark">No Enviado</span>',
                'fecha' => $email->created_at->format('d/m/Y H:i'),
            ];

            // Si es admin, agregar columna de usuario
            if (auth()->user()->is_admin) {
                $row['usuario'] = $email->user->nombre;
            }

            return $row;
        });

        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ]);
    }
}
