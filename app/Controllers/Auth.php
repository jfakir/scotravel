<?php

namespace App\Controllers;

use App\Models\ForgetPasswordmodel;
use App\Models\Usermodel;

helper(['session']);

class Auth extends BaseController
{
    protected $encrypter;
    public function __construct()
    {
    }
    public function login()
    {
        // Check if the request is AJAX
        if ($this->request->isAJAX()) {
            $userModel = new UserModel();
            $result = $userModel->login($this->request->getPost('email'), $this->request->getPost('password'));
            if ($result['status']) {
                // If login successful
                $user = $result['user'];
                $user_data = [
                    'user_id' => $user['id'],
                    'email' => $user['email'],
                    'fname' => $user['fname'],
                    'lname' => $user['lname'],
                    'account_type' => $user['account_type'],
                    'access_type' => $user['access_type']
                ];
                session()->set($user_data);
                session()->setFlashdata('message_success', 'Welcome ' . $user['fname'] . ' ' . $user['lname']);
                return $this->response->setJSON([
                    'status' => true,
                    'token' => csrf_hash()
                ]);
            } else {
                // If login failed
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Invalid credentials', // Provide a more specific error message
                    'token' => csrf_hash()
                ]);
            }
        } else {
            // If not AJAX, handle non-AJAX requests
            if (session()->has('user_id')) {
                return redirect()->to('trips/upcoming');
            } else {
                return view('authentication/login');
            }
        }
    }

    public function signup()
    {
        // Check if the request is AJAX
        if ($this->request->isAJAX()) {
            $userModel = new UserModel();
            // Load validation library
            if ($userModel->checkEmailExists($this->request->getPost('email'))) {
                return $this->response->setJSON([
                    'status' => false,
                    'data' => 'Email already exists.',
                ]);
            }

            if ($userModel->checkPhoneExists($this->request->getPost('phone'), $this->request->getPost('country_code'),  $this->request->getPost('phone_code'))) {
                return $this->response->setJSON([
                    'status' => false,
                    'data' => 'Phone already exists.',
                ]);
            }

            $password = password_hash((string)$this->request->getPost('password'), PASSWORD_DEFAULT);
            $userData = [
                'fname' => $this->request->getPost('fname'),
                'lname' => $this->request->getPost('lname'),
                'email' => $this->request->getPost('email'),
                'phone' => $this->request->getPost('phone_formatted'),
                'country_code' => $this->request->getPost('country_code'),
                'phone_code' => $this->request->getPost('phone_code'),
                'password' => $password,
                'account_type' => $this->request->getPost('account_type'),
                'is_subscribed' => $this->request->getPost('is_subscribed'),
            ];

            $userID = $userModel->addUser($userData);
            $encodedUserID = base64_encode($userID);
            $emailContent = '
            <html>
            <head>
            <title>Verify Your Account - ScoTravel</title>
            </head>
            <body>
            <p>Dear ' . $this->request->getPost('fname') . ',</p>
            <p>Thank you for signing up with ScoTravel! To complete your registration, please click on the link below to verify your account:</p>
            <p><a href="' . base_url() . 'verifyAccount?userID=' . $encodedUserID . '">Verify Account</a></p>
            <p>If you did not sign up for a ScoTravel account, please ignore this email.</p>
            <p>Thank you,</p>
            <p>ScoTravel Support Team</p>
            </body>
            </html>
            ';

            $email = \Config\Services::email();
            $email->setFrom('no-reply@sconet.com', 'ScoTravel Support Team');
            $email->setTo($this->request->getPost('email'));
            $email->setSubject('Verify Your ScoTravel Account');
            $email->setMessage($emailContent);
            $email->setMailType('html'); // Set email content type to HTML for proper formatting
            $email->send();

            if ($userID) {
                session()->setFlashdata('message_success', 'Account Registered. Please check your inbox to verify your email');
                return $this->response->setJSON([
                    'status' => true,
                ]);
            } else {
                session()->setFlashdata('message_error', 'Connection error');
                return $this->response->setJSON([
                    'status' => false,
                ]);
            }
        } else {
            // If not an AJAX request, handle non-AJAX requests
            return view('authentication/signup');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect('/');
    }

    public function verifyAccount()
    {

        if ($this->request->isAjax()) {
            $userModel = new UserModel();
            $token = $this->request->getPost('token');
            $userID = base64_decode((string)$token);

            // 3 - Set the correct data
            $userData = [
                'is_verified' => 1
            ];
            // 4 - Update the profile of the shared user id
            $updated = $userModel->update($userID, $userData);

            // 5 - Check the update status
            if ($updated) {
                // Account verified successfully
            // print_r(1);exit();

                session()->setFlashdata('message_success', 'Account verified');
                // return redirect('/');
                // return view('authentication/login');
                return $this->response->setJSON([
                    'status' => true,
                ]);
            } else {
            // print_r(-1);exit();

                // Unable to verify account
                session()->setFlashdata('message_error', 'Unable to verify account');
                // return redirect('/');
                // return view('authentication/login');
                return $this->response->setJSON([
                    'status' => false,
                ]);
            }

        } else{
            // 1 - Get the attribute from the link
            $userID = $this->request->getGet('userID');
            if ($userID) {
                // 2 - We check if the id exists.
                $userModel = new UserModel();
                $checkUser = $userModel->find(base64_decode((string)$userID));
                if (!$checkUser) {
                    // If the user doesn't exists
                    session()->setFlashdata('message_error', 'Access denied');
                    return redirect('/');
                }

                return view('authentication/verifyAccount');

               
                // 6 - Handle the URL if there's no verification link
            } else {
                // userID is not provided
                session()->setFlashdata('message_error', 'Access denied');
                return redirect('/');
            }
        } 

       
    }


    public function resetPassword()
    {
        if ($this->request->isAjax()) {
            $userModel = new UserModel();
            $user = $userModel->getByMail($this->request->getPost('email'));
            if (!$user) {
                return $this->response->setJSON([
                    'status' => false,
                    'data' => 'Email not found'
                ]);
            }
            $userID = $user['id'];
            $encodedUserID = base64_encode($userID);
            $forgetPasswordModel = new ForgetPasswordModel();
            $tokenData = [
                'user_id' => $userID,
                'token' => $encodedUserID,
            ];
            $token = $forgetPasswordModel->addToken($tokenData);
            if (!$token) {
                return $this->response->setJSON([
                    'status' => false,
                    'data' => 'Unable to generate reset link'
                ]);
            }
            $emailContent = '
            <html>
            <head>
            <title>Reset Your Password - ScoTravel</title>
            </head>
            <body>
            <p>Dear ' . $user['fname'] . ' ' . $user['lname'] . ',</p>
            <p>You have requested to reset your passowrd. To complete the process, please click on the link below:</p>
            <p><a href="' . base_url() . 'resetPassword?token=' . $encodedUserID . '">Reset Password</a></p>
            <p>If you did not request to reset password, please ignore this email.</p>
            <p style="color:red !important;">This link will expire in 2 days.</p>
            <p>Thank you,</p>
            <p>ScoTravel Support Team</p>
            </body>
            </html>
            ';

            $email = \Config\Services::email();
            $email->setFrom('no-reply@sconet.com', 'ScoTravel Support Team');
            $email->setTo($this->request->getPost('email'));
            $email->setSubject('Reset Password Of Your ScoTravel Account');
            $email->setMessage($emailContent);
            $email->setMailType('html'); // Set email content type to HTML for proper formatting
            $email->send();

            return $this->response->setJSON([
                'status' => true,
            ]);
        } else {
            if (!$this->request->getGet('token')) {
                session()->setFlashdata('message_error', 'Invalid link');
                return redirect('/');
            }

            $forgetPasswordModel = new ForgetPasswordModel();
            $token = $forgetPasswordModel->getToken($this->request->getGet('token'));
            if ($token) {
                $requestedOn = strtotime($token['requested_on']);
                $twoDaysAgo = strtotime('-2 days');
                $tokenData = [
                    'is_deleted' => 1
                ];
                $forgetPasswordModel = new ForgetPasswordModel();
                $forgetPasswordModel->updateToken($token['id'], $tokenData);
                if ($requestedOn < $twoDaysAgo) {
                    session()->setFlashdata('message_error', 'Token not found or expired. Please request a new one');
                    return redirect('/');
                } else {
                    return view('authentication/resetPassword');
                }
            } else {
                // If no token was found
                session()->setFlashdata('message_error', 'Token not found or expired. Please request a new one');
                return redirect('/');
                
            }
        }
    }

    public function updatePassword()
    {
        if ($this->request->isAjax()) {
            $userID = (base64_decode(urldecode((string)$this->request->getPost('token'))));
            $userModel = new UserModel();
            $password = password_hash((string)$this->request->getPost('password'), PASSWORD_DEFAULT);
            $userData = [
                'password' => $password
            ];
            $result = $userModel->updateUser($userID, $userData);
            if ($result) {
                session()->setFlashdata('message_success', 'Password Updated');
                return $this->response->setJSON([
                    'status' => true,
                ]);
            } else {
                session()->setFlashdata('message_error', 'Failed to update password. Please try again.');
                return $this->response->setJSON([
                    'status' => false,
                ]);
            }
        }
    }
}
