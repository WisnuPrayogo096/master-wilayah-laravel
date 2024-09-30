<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attribute\Layout;

class Login extends Component
{
    public $password;

    protected $rules = [
        'password' => 'required',
    ];

    public function login()
    {
        $this->validate();

        if(Auth::attempt([
            'email' => 'admin@ummhospital.com',
            'password' => $this->password,
        ])){
            session()->regenerate();
            return $this->redirect('/');
        }

        $this->addError('password', 'Invalid password');
        $this->password = '';
    }


    public function render()
    {
        return view('livewire.auth.login')
        ->layout('layouts.basic');
    }
}
