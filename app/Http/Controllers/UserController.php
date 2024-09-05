<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
	function apis(Request $request)
	{
		$users = User::select(['id', 'name', 'role', 'email', 'updated_at'])->orderBy('updated_at', 'desc');

		return DataTables::of($users)
			->addColumn('action', function ($row) {
				$deleteButton = $row->id == 1
					? '<button class="btn btn-sm btn-danger" disabled><i class="bi bi-person-x"></i></button>'
					: '<button data-id="' . $row->id . '" class="btn btn-sm btn-danger delete-btn"><i class="bi bi-person-x"></i></button>';

				return '
                <button data-id="' . $row->id . '" class="btn btn-sm btn-warning edit-btn"><i class="bi bi-person-gear"></i></button>
                ' . $deleteButton . '
            ';
			})
			->editColumn('updated_at', function ($user) {
				return $user->updated_at->format('Y-m-d H:i:s');
			})
			->rawColumns(['action'])
			->make(true);
	}

	function index()
	{
		return view('admin.users.index');
	}

	function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'name'      => 'required|string|max:255',
			'email'     => 'required|email|max:255|unique:users',
			'role'      => 'required|string',
			'password'  => 'required|min:8',
		], [
			'required' => ':attribute wajib diisi.',
			'string'   => ':attribute harus berupa teks.',
			'max'      => ':attribute tidak boleh lebih dari :max karakter.',
			'email'    => 'Format :attribute tidak valid.',
			'unique'   => ':attribute sudah terdaftar.',
			'min'      => ':attribute harus memiliki minimal :min karakter.',
		]);

		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()], 422);
		}

		try {
			User::create([
				'name'		=> $request->name,
				'email' 	=> $request->email,
				'role' 		=> $request->role,
				'password' 	=> bcrypt($request->password),
			]);

			return response()->json(['success' => 'User has been added successfully.']);
		} catch (\Exception $e) {
			return response()->json(['error' => 'An error occurred.'], 500);
		}
	}

	function edit(Request $request)
	{
		$id = $request->id;
		$user = User::findOrFail($id);

		return response()->json([
			'status' => 'success',
			'data' => $user
		]);
	}

	public function update(Request $request)
	{
		// Validasi input
		$validator = Validator::make($request->all(), [
			'id'        => 'required|integer|exists:users,id',
			'name'      => 'required|string|max:255',
			'email'     => 'required|email|max:255',
			'role'      => 'required|string|in:super-admin,admin',
			'password'  => 'nullable|string|min:8', // Password opsional
		], [
			'required'  => ':attribute wajib diisi.',
			'email'     => 'Format :attribute tidak valid.',
			'unique'    => ':attribute sudah terdaftar.',
			'string'    => ':attribute harus berupa teks.',
			'max'       => ':attribute tidak boleh lebih dari :max karakter.',
			'min'       => ':attribute harus memiliki minimal :min karakter.',
		]);

		// Jika validasi gagal, kirimkan respon JSON dengan error
		if ($validator->fails()) {
			return response()->json([
				'status' => 'error',
				'errors' => $validator->errors()
			], 422);
		}

		try {
			// Temukan pengguna berdasarkan ID yang diterima dari request AJAX
			$user = User::findOrFail($request->id);

			// Update data pengguna
			$user->name  = $request->name;
			$user->email = $request->email;
			$user->role  = $request->role;

			// Update password hanya jika disediakan
			if ($request->filled('password')) {
				$user->password = bcrypt($request->password);
			}

			// Simpan perubahan
			$user->save();

			// Respon sukses
			return response()->json([
				'status' => 'success',
				'message' => 'User updated successfully'
			]);
		} catch (\Exception $e) {
			// Jika ada error, kirimkan respon JSON dengan pesan error
			return response()->json([
				'status' => 'error',
				'message' => 'An error occurred while updating user'
			], 500);
		}
	}


	function destroy(Request $request)
	{
		$id = $request->id;

		$data = User::find($id);
		if ($data) {
			try {
				$data->delete();
				return response()->json(['success' => 'User has been deleted successfully.']);
			} catch (\Exception $e) {
				return response()->json(['error' => 'Failed to delete user. Please try again later.'], 500);
			}
		}

		return response()->json(['error' => 'User not found.'], 404);
	}
}
