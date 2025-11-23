<?php

namespace App\Livewire\Auth\User\Register;

use create;
use App\Models\User;
use App\Enums\OtpType;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Services\UserService;
use App\Mail\OtpVerificationMail;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Traits\Livewire\WithNotification;

class SetEmail extends Component
{

    use WithNotification;


    protected UserService $service;
    #[Validate('required|email|unique:users,email')]
    public $email = '';


    public function boot(UserService $service)
    {
        $this->service = $service;
    }

    public function mount()
    {
        if (!session()->has('registration.first_name') || !session()->has('registration.last_name')) {
            $this->error('First name and last name are required.');
            return $this->redirect(route('register.signUp'), navigate: true);
        }
    }

    public function save()
    {


        $firstName = session('registration.first_name');
        $lastName = session('registration.last_name');

        $validate = $this->validate();

        try {
            $user = $this->service->createData([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'username' => generate_username($firstName, $lastName),
                'email' => $this->email,
                'avatar' => null,
            ]);

            $otp = create_otp($user, OtpType::EMAIL_VERIFICATION, 10);
            try {

                // Send OTP via email
                Mail::to($user->email)->send(
                    new OtpVerificationMail(
                        $otp->code,
                        $user->first_name,
                        $otp->expires_at
                    )
                );



                Log::info('OTP Email Verification', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'otp_code' => $otp->code,
                    'expires_at' => $otp->expires_at,
                ]);
            } catch (\Exception $mailException) {
                Log::error('Failed to send OTP email: ' . $mailException->getMessage());
            }

            session([
                'registration.user_id' => $user->id,
                'registration.email' => $this->email,
            ]);

            session()->forget([
                'registration.first_name',
                'registration.last_name'
            ]);
            $this->dispatch('User Created');
            $this->success('User created successfully');
            return $this->redirect(route('register.otp'), navigate: true);
        } catch (\Exception $e) {
            Log::error('Failed to create user:' . $e->getMessage());
            $this->error('Failed to create user.');
            
        }
    }



    public function back()
    {
        return $this->redirect(route('register.signUp'), navigate: true);
    }



    public function render()
    {
        return view('livewire.auth.user.register.set-email');
    }
}
