<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public string $email = '';
    public  string $password = '';
    public bool $remember = false;

    public function rules():array
    {
        return [
            'email'=>'required|email',
            'password'=>'required|min:8'
        ];
    }
    public function messages():array
    {
        return [
            'email.required'=>'Ingresa tu e-mail',
            'email.email'=>'Ingrese un formato válido',
            'password.required'=>'La contraseña es requerida',
            'password.min'=>'Ingrese una contraseña válida',
        ];
    }
    public function submit()
    {
        $this->validate();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        $this->addError('email', 'Las credenciales dadas no son válidas.');
    }



    public function render()
    {
        return view('livewire.auth.login');
    }
}
