<?php

namespace App\Http\Controllers\Auth;

use App\User;
use DB;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Mail;
class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
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
            'name' => 'required|max:255|unique:users',
            'cellulare' => 'required',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $pswd = $data['password'];
        // $email = $data['email'];
        // $length = 20;
        // $emailutente = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);

        $user = User::create([
            'name' => $data['name'],
            'cellulare' => $data['cellulare'],
            'password' => bcrypt($pswd),
            'email' => $data['email'],
            'utente_commerciale' => $data['commerciale'],
            'id_citta' => $data['city'],
            'id_stato' => $data['state'],
            'dipartimento' => 'RESELLER'
        ]);

         DB::table('rivenditore')->insert([
                'name' => $data['name'],
                'cellulare' => $data['cellulare'],
                'password' => bcrypt($pswd),
                'email' => $data['email'],
                'utente_commerciale' => $data['commerciale'],
                'id_citta' => $data['city'],
                'id_stato' => $data['state'],
                'dipartimento' => 'RESELLER'
            ]);
        
        
        // Mail::send('nuovaregistrazione', ['user' => $user, 'pswd' => $pswd, 'emailutente' => $email], function ($m) use ($user) {
        //     $m->from($user->email, 'Easy LANGA');
        //     $m->to('amministrazione@langa.tv', 'amministrazione@langa.tv')->subject('RICHIESTA CONFERMA REGISTRAZIONE CLIENTE_Easy LANGA');
        // });

        $this->redirectTo = "/nuovoutente";
       // return redirect('/login')->flash('success', 'Success!', 'Successfully created new list!'); 
        
        return $user;
    }
}
