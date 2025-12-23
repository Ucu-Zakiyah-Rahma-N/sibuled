<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data = [
            'title' => 'User',
            'users' => User::with('customer')
                    ->paginate(10),
        ];

        return view('admin.user', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();

        return view('admin.user_create', [
            'title'     => 'User',
            'customers' => $customers
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => ['nullable',
                        function ($attribute, $value, $fail) {
                // Jika pilihannya bukan "simply" dan bukan null, cek apakah sudah ada user
                if ($value && User::where('customer_id', $value)->exists()) {
                    $fail('User untuk customer ini sudah pernah dibuat.');
                }
            }
        ],
            'username' => 'required|string|unique:users,username',
            'password' => 'required|min:4',
            'role' => 'required',
        ]);

        $customer = Customer::find($request->customer_id);
        $customerId = $request->customer_id === 'simply' ? null : $request->customer_id;

        User::create([
            'customer_id' => $customerId,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role'     => $request->role, // langsung dari input form
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = [
            'title' => 'User',
            'user' => User::findOrFail($id)
        ];

        return view('admin.user_detail', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'username'   => 'required|string|max:100',
            'email'      => 'required|email|max:100',
            'customer_id'  => 'required|exists:customer,id',
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'username'   => $request->username,
            'email'      => $request->email,
            'customer_id'  => $request->customer_id,
        ]);

        return redirect()->back()->with('success', 'Data user berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User berhasil dihapus']);
    }


    public function ubahPassword($id)
    {
        $data = [
            'title' => 'Ubah Password',
            'user' => User::findOrFail($id)
        ];

        return view('auth.ubah_password', $data);
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required',
            'password_confirmation' => 'required|same:password'
        ]);

        $passwordhash = Hash::make($request->password);

        User::where('id', '=', $id)->update([
            'password' => $passwordhash
        ]);

    return redirect()->route('users.index')->with('success', 'Berhasil mengubah password');
    }

    public function search(Request $request)
    {
     $keyword = $request->get('q'); // ambil keyword dari input search

    $results = DB::table('customers')
        ->where('nama_perusahaan', 'LIKE', "%{$keyword}%")
        ->select('id', 'nama_perusahaan as username')
        ->get();

    return response()->json($results);    
    }
}
