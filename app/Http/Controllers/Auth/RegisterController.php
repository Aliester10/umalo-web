<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:t_users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'string', 'max:15'],
            'address' => ['required', 'string'],
            'company_name' => ['required', 'string'],
            'pic_phone' => ['required', 'string', 'max:15'],
            'deed_of_establishment' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png'],
            'nib_document' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png'],
            'name' => ['required', 'string', 'max:255'],
            ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */


     protected function registered(\Illuminate\Http\Request $request, $user)
    {
        // Logout user setelah registrasi
        auth()->logout();

        // Redirect dengan pesan sukses
        return response()->json([
            'success' => true,
            'message' => 'Akun Anda berhasil didaftarkan. Silakan tunggu konfirmasi dari admin.'
        ]);
    }


    protected function create(array $data)
    {

        $validator = Validator::make($data, [
            'email' => 'required|email|unique:t_users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
            'company_name' => 'required|string',
            'pic_phone' => 'required|string|max:15',
            'name' => 'required|string|max:255',
            'deed_of_establishment' => 'required|file|mimes:pdf,jpg,jpeg,png',
            'nib_document' => 'required|file|mimes:pdf,jpg,jpeg,png',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }


        // Tentukan direktori tujuan di dalam public
        $deedDirectory = public_path('distributor/documents/akta');
        $nibDirectory = public_path('distributor/documents/nib');

        if (!file_exists($deedDirectory)) {
            mkdir($deedDirectory, 0777, true);
        }
        if (!file_exists($nibDirectory)) {
            mkdir($nibDirectory, 0777, true);
        }

        // Simpan file di public_path
        $deedFileName = time() . '_deed_' . $data['deed_of_establishment']->getClientOriginalName();
        $nibFileName = time() . '_nib_' . $data['nib_document']->getClientOriginalName();

        $data['deed_of_establishment']->move($deedDirectory, $deedFileName);
        $data['nib_document']->move($nibDirectory, $nibFileName);

        // Simpan path relatif di database
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'address' => $data['address'],
            'company_name' => $data['company_name'],
            'pic_phone' => $data['pic_phone'],
            'deed_of_establishment' => 'distributor/documents/akta/' . $deedFileName,
            'nib_document' => 'distributor/documents/nib/' . $nibFileName,
            'is_verified' => false, 
            'type' => 2
        ]);
    }

    



}
