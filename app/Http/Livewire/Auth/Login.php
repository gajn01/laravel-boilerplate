<?php
namespace App\Http\Livewire\Auth;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Helpers\CustomHelper;
class Login extends Component
{
    public $email;
    public $password;
    public $remember_me = false;
    public function render()
    {
        return view('livewire.auth.login')->extends('layouts.auth');
    }
    public function onLogin()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            CustomHelper::onShow($this, false, 'Success.', 'Successfully logged in!', 'success', '');
            return redirect()->to('/dashboard');
        } else {
            CustomHelper::onShow($this, false, 'Invalid credentials.', 'Invalid email or password. Please try again.', 'error', '');
        }
    }
}
