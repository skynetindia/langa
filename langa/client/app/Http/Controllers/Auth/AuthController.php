<?php

namespace App\Http\Controllers\Auth;

use App\User;
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

        return  Validator::make($data, [
            'nomeazienda' => 'required',
            'nomereferente' => 'required',
            'telefonoprimario' => 'required',
            'emailprimaria' => 'required|email|max:255|unique:corporations',
            'settore' => 'required',
            'telefonosecondario' => '',
            'emailsecondario' => 'email|max:255|unique:corporations',
            'fax' => '',
            'statoemotivo' => '',
            'cf' => 'numeric',
            'cartadicredito' => 'numeric',
            'iban' => '',
            'swift' => '',
            'sedelegale' => '',
            'indirizzospedizione' => '',
            // 'logo' => 'image|max:50000'
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
        // $pswd = $data['password'];
        // $email = $data['email'];
        // $length = 20;
        // $emailutente = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);

        $user = User::create([
            'nomeazienda' => $data['nomeazienda'],
            'nomereferente' => $data['nomereferente'],
            'telefonoprimario' => $data['telefonoprimario'],
            'emailprimaria' => $data['emailprimaria'],
            'settore' => $data['settore'],
            'telefonosecondario' => $data['telefonosecondario'],
            'emailsecondaria' => $data['emailsecondaria'],
            'fax' => $data['fax'],
            'statoemotivo' => $data['statoemotivo'],
            'cf' => $data['cf'],
            'cartadicredito' => $data['cartadicredito'],
            'iban' => $data['iban'],
            'swift' => $data['swift'],
            'sedelegale' => $data['sedelegale'],
            'indirizzospedizione' => $data['indirizzospedizione'],
            'logo' => $data['logo']
        ]);
        
        // Mail::send('nuovaregistrazione', ['user' => $user, 'pswd' => $pswd, 'emailutente' => $email], function ($m) use ($user) {
        //     $m->from($user->email, 'Easy LANGA');
        //     $m->to('amministrazione@langa.tv', 'amministrazione@langa.tv')->subject('RICHIESTA CONFERMA REGISTRAZIONE CLIENTE_Easy LANGA');
        // });

        $this->redirectTo = "/login";
        
        return $user;
    }
}
