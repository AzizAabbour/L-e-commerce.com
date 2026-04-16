<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'client');

        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $clients = $query->paginate(20);
        return view('admin.clients.index', compact('clients'));
    }

    public function destroy($id)
    {
        User::where('role', 'client')->findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Client supprimé.');
    }
}
