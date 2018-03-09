<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Input;
use Auth;
use Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    
    public function rejestracja() {
        if (!Auth::check()) {
    
        return view('rejestracka');
        }
        else {
         return Redirect('glowna');
        }
    }
    
 
    public function zarejestruj() {
   
     $rules = array(
        
      'login' => 'required|min:4|unique:users',
      'haslo' => 'required|same:haslo2',
      'email' => 'required|email',
      'haslo' => 'required|min:6',
      'email' => 'required|email|unique:users',
   
    );
      
  
     $validation = Validator::make(Input::all(), $rules);
     if (($validation->fails()) )
      {

            return Redirect('rejestracja')->withErrors($validation)->withInput();
    
        
      }
      
     $user = new \App\User;
     $user->email = htmlspecialchars(Input::get('email'));
     $user->password = Hash::make(Input::get('haslo'));
     $user->login = htmlspecialchars(Input::get('login'));
     if ($user->save())
     {

	     return Redirect('rejestracja_sukces');
     }	
    }
    
    private function sprawdz_email($email) {
        if (!strstr($email,"@") ) {
            return -1;
        }
        return 0;
    }
    
        public function registration() {
   if (!Auth::check()) {
    return View::make('/regi');
    }
    else {

      return View::make('blad');
    }
    
    
    }

    
    protected function validateLogin(Request $request)
        {

            $this->validate($request, [
                $this->username() => 'required|string',
                'password' => 'required|string',
            ]);
        }
    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
    }
    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }
    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();
        $this->clearLoginAttempts($request);
        return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath());
    }
    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        //
    }
    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }
    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }
    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        return redirect('/');
    }
    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
    
    
    public function zaloguj() {
        return view('zaloguj');
    
    }
    
        public function login(Request $request)
    {
        $this->validateLogin($request);

    }
    
    public function blad() {
        return View('blad');
        
    }
    public function wyloguj() {
        Auth::logout();
        return Redirect('zaloguj');
    }
    public function logowanie() {
    
        $haslo = Input::get('password');

        $user = array(
            'login' => Input::get('name'),
            'password' => Input::get('password')
        );
        $haslo2 = Hash::make($user['password']);

        if (Input::get('name') == "" and Input::get('haslo') == "" ) {
            return Redirect('blad')->with('login_error','Uzupełnij pole login i hasło');
        }
        
        if (Auth::attempt($user))
        {
            return Redirect('glowna');
        }
        else {

            return Redirect('blad')->with('login_error','Nieprawidłowy login lub hasło');
        }
    }
    public function rejestracja_sukces() {
        return view('rejestracja_sukces');
        
        
    }
    private function sprawdz_dzien($poczatek_dnia) {
        $status = false;
        $ile = count( explode( ':', $poczatek_dnia ) );
        if ($ile-1 == 2) {
            $podziel = explode(":",$poczatek_dnia);
                if (strlen($podziel[0]) == 2 and strlen($podziel[1]) == 2 and strlen($podziel[2]) == 2) $status = true;

        }
        print $status;
        if ($status == true and $ile-1 == 2) return 0;
        return -1;
        
    }
    public function blad_rejestracji() {
    
        return View('rejestracka2');
       
    }
    
    private function add_regi() {
    
        $rules = array(
            'email' => 'required|email|unique:users',
            'password' => 'required|same:password2',
            'name'=> 'required|unique:users'
      );
      $validation = Validator::make(Input::all(), $rules);
      if ($validation->fails())
      {
            return Redirect('registration')->withErrors($validation)->withInput();
      }
      $user = new \App\User;
      $user->email = htmlspecialchars(Input::get('email'));
      $user->password = Hash::make(Input::get('password'));
      $user->name = htmlspecialchars(Input::get('login'));
      if ($user->save())
      {
	
            return Redirect('registration_succes');
      }	
    
    }
}
