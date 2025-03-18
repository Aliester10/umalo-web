<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Carbon;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your  screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function login(Request $request)
    {
        // Validate the request input
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Get the user's email
        $email = $request->email;

        // Check if the user has exceeded the login attempts
        $loginAttempts = Cache::get($email . '_login_attempts', 0);
        $lockoutTime = Cache::get($email . '_lockout_time');

        // If the user is locked out
        if ($lockoutTime && Carbon::now()->lessThan($lockoutTime)) {
            $remainingMinutes = Carbon::now()->diffInMinutes($lockoutTime);
            return redirect()->route('login')
                ->with('error', 'Akun Anda telah diblokir sementara. Silakan coba lagi setelah ' . $remainingMinutes . ' menit.');
        }

        // Attempt to authenticate the user
        if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            // Reset login attempts if successful

            $user = auth()->user();

            if (!$user->is_verified) {
                // Logout the user if not verified
                auth()->logout();
                return redirect()->route('login')
                ->with('error', 'Akun Anda belum diverifikasi. Mohon periksa kotak masuk email Anda untuk menyelesaikan proses verifikasi. Terima kasih atas kesabaran Anda.');
            }

            Cache::forget($email . '_login_attempts');
            Cache::forget($email . '_lockout_time');

            // Get the authenticated user
            $user = auth()->user();

            // Check the user's type and redirect accordingly
            if ($user->type == 'admin') {
                return redirect()->route('dashboard');
            } else if ($user->type == 'member') {
                return redirect('member/dashboard');
            } else if ($user->type == 'distributor') {
                return redirect('distributor/dashboard');
            }
        } else {
            // Increment login attempts
            Cache::increment($email . '_login_attempts');
            $loginAttempts += 1;

            // Check if this is the 4th failed attempt
            if ($loginAttempts == 4) {
                return redirect()->route('login')
                    ->with('error', 'Peringatan keras: Jika Anda salah memasukkan email atau password lagi, akun Anda akan terkena banned selama 5 jam.');
            }

            // If login attempts exceed 5, lock the user for 5 hours
            if ($loginAttempts >= 5) {
                $lockoutTime = Carbon::now()->addHours(5);
                Cache::put($email . '_lockout_time', $lockoutTime, $lockoutTime);
                return redirect()->route('login')
                    ->with('error', 'Akun Anda telah diblokir sementara karena terlalu banyak percobaan login. Silakan coba lagi setelah 5 jam.');
            }

            // Authentication failed, send error message
            return redirect()->route('login')
                ->with('error', 'Email atau Password salah.');
        }
    }




    public function logout(Request $request)
    {
        $user = Auth::user();  // Capture the user before logging out

        Auth::logout();  // Log the user out
        $request->session()->invalidate();  // Invalidate the session
        $request->session()->regenerateToken();  // Regenerate the CSRF token

        // Redirect based on user role
        if ($user->role == 'admin') {
            return redirect('/login');  // Redirect admin users to the login page
        } elseif ($user->role == 'member') {
            return redirect('/');  // Redirect customer users to the  page
        }

        return redirect('/');  // Fallback to  for other roles
    }
}
