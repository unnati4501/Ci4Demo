<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\User;
use CodeIgniter\I18n\Time;

class AuthController extends BaseController
{
    public function __construct()
    {
        helper(['url', 'form']);
       
    }

    public function register(){
        
        $token = bin2hex(random_bytes(16)); // verification token

        $validation = \Config\Services::validation();

        $data = [];
        $userModel = new User();
        if($this->request->getMethod() == 'POST'){
            
            $rules = [
                'username' => 'required|min_length[3]|is_unique[users.username]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[8]',
                'confirm_password' => 'matches[password]'
            ];
            
            if (! $this->validate($rules)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'errors' => $validation->getErrors()
                ]);
            }

            $userModel->save([
                'username'     => $this->request->getPost('username'),
                'email'    => $this->request->getPost('email'),
                'password' => $this->request->getPost('password'),
                'verification_token' => $token
            ]);
            $this->_sendVerificationEmail($this->request->getVar('username'), $this->request->getVar('email'), $token);

            session()->setFlashdata('success', 'Registration successfully!');

            return $this->response->setJSON([
                'status'  => 'success',
                'redirect' => base_url('/login')
            ]);        }
        return view('auth/register', $data);
    }

    private function _sendVerificationEmail($username, $email, $token)
    {
        $emailService = \Config\Services::email();

        $verificationLink = base_url("auth/verify/$token");

        $data = [
            'username' => $username,
            'verification_link' => $verificationLink,
            'app_name' => 'MyApp'
        ];
        $message = view('email/verification_email', $data);


        $emailService->setTo($email);
        $emailService->setFrom('noreply@example.com', 'MyApp');
        $emailService->setSubject('Verify your account');
        $emailService->setMessage($message);

        if (!$emailService->send()) {
            log_message('error', 'Email failed: ' . $emailService->printDebugger(['headers']));
        }
    }

    public function verify($token = null)
    {
        if (!$token) {
            return redirect()->to('/login')->with('error', 'Invalid verification link.');
        }

        $userModel = new User();
        $user = $userModel->where('verification_token', $token)->first();

        if (!$user) {
            return redirect()->to('/login')->with('error', 'Invalid or expired verification link.');
        }

        $userModel->update($user['id'], [
            'is_verified' => 1,
            'verification_token' => null
        ]);

        return redirect()->to('/login')->with('success', 'Email verified successfully! You can now login.');
    }


    public function login() 
    {
        $data = [];
        $userModel = new User();
        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'email'    => 'required|valid_email',
                'password' => 'required'
            ];

            if (! $this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $user = $userModel->where('email', $this->request->getPost('email'))->first();
            
            if ($user && password_verify($this->request->getPost('password'), $user['password'])) {
                // set session
                session()->set([
                    'isLoggedIn' => true,
                    'userId'     => $user['id'],
                    'userName'   => $user['username'],
                    'userEmail'  => $user['email'],
                ]);

                return redirect()->to('/employee');
            }else {
                session()->setFlashdata('error', 'Invalid email or password');
                return redirect()->to('/login');
            }
        }
        return view('auth/login', $data);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

}
