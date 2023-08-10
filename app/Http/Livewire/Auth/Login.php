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
            'password' => 'required|min:8',
        ]);
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            if(Auth::user()->email_verified_at){
                CustomHelper::onShow($this, false, 'Success.', 'Successfully logged in!', 'success', '');
                if(Auth::user()->user_type < 2){
                    return redirect()->to('/dashboard');
                }else{
                    return redirect()->to('/audit');
                }
            }else{
             CustomHelper::onShow($this, false, 'Account is not verified', 'Account is not verified', 'warning', '');
            }
        } else {
            CustomHelper::onShow($this, false, 'Invalid credentials.', 'Invalid email or password. Please try again.', 'error', '');
        }
    }
}
