<?php

namespace App\Services\Auths;

use App\Models\Role;
use App\Models\User;
use App\Repositories\Users\UserRepository;
use App\Repositories\Roles\RoleRepository;
use App\Services\EmailService;
use Illuminate\Support\Facades\DB;

class AuthService
{
    protected $userRepository;

    protected $emailService;

    protected $roleRepository;

    public function __construct(
        UserRepository $userRepository,
        RoleRepository $roleRepository,
        EmailService $emailService
    )
    {
        $this->userRepository = $userRepository;
        $this->emailService = $emailService;
        $this->roleRepository = $roleRepository;
    }

    public function postRegister($inputs)
    {
        try {
            $checkUser = NULL;

            if (!empty($inputs['ref_code'])) {
                $checkUser = $this->userRepository->findUserByRefCode($inputs['ref_code']);

                if (empty($checkUser)) {
                    return [
                        'success' => false,
                        'message' => 'Mã giới thiệu không tồn tại'
                    ];
                }
            }
            $inputs['ref_code'] = 'SV_' . substr(rand(), rand(0, 3), 8);
            $inputs['role_code'] = empty($checkUser) ? Role::ROLE_SHOP : Role::ROLE_AGENCY;
            $inputs['password'] = bcrypt($inputs['password']);
            $inputs['parent_id'] = empty($checkUser) ? 0 : $checkUser->id;
            $inputs['token'] = md5(bin2hex(random_bytes(100)));
            $resultSendMail = $this->emailService->verifyEmail($inputs['email'], $inputs['token']);

            if ($resultSendMail) {
                DB::beginTransaction();
                if (!empty($checkUser)) {
                    $this->userRepository->update($checkUser->id, ['role_code' => Role::ROLE_AGENCY]);
                }
                $this->userRepository->create($inputs);
                DB::commit();

                return [
                    'success' => true,
                    'message' => config('const.auth.send_mail_after_register')
                ];
            }

            return [
                'success' => false,
                'message' => 'Gửi Email thất bại'
            ];
        } catch (\Throwable $th) {
            DB::rollback();

            return [
                'success' => false,
                'message' => 'Vui lòng thử lại'
            ];
        }
    }

    public function verifyEmail($token)
    {
        try {
            $checkUser = $this->userRepository->findUserByToken($token);

            if (empty($checkUser)) {
                return [
                    'success' => false,
                    'message' => 'Không tồn tại token này',
                    'title' => 'Thất bại'
                ];
            } else {
                $checkUser->update([
                    'status' => User::ACTIVE,
                    'email_verified_at' => date('Y-m-d H:i:s')
                ]);

                return [
                    'success' => true,
                    'message' => 'Xác thực Email thành công',
                    'title' => 'Thành công'
                ];
            }
        } catch (\Throwable $th) {
            return [
                'success' => false,
                'message' => 'Vui lòng thử lại',
                'title' => 'Thất bại'
            ];
        }
    }

    public function postLogin($inputs)
    {
        try {
            $credential_emails = [
                'email' => $inputs['email'],
                'password' => $inputs['password'],
                'status' =>1
            ];
            $credential_phone = [
                'phone' => $inputs['email'],
                'password' => $inputs['password'],
                'status' =>1
            ];
            $remember = empty($inputs['remember']) ? false : true;

            if (auth()->attempt($credential_emails, $remember) || auth()->attempt($credential_phone, $remember)) {
                return [
                    'success' => true
                ];
                // $user = auth()->user();

                // if (empty($user->email_verified_at)) {
                //     $this->emailService->verifyEmail($user->email, $user->token);
                //     auth()->logout();

                //     return [
                //         'success' => false,
                //         'message' => config('const.auth.login_not_verify_email')
                //     ];
                // } else {
                //     return [
                //         'success' => true
                //     ];
                // }
            } else {
                return [
                    'success' => false,
                    'message' => 'Thông tin đăng nhập sai, vui lòng thử lại'
                ];
            }
        } catch (\Throwable $th) {
            return [
                'success' => false,
                'message' => 'Vui lòng thử lại'
            ];
        }
    }

    public function postLoginAdmin($inputs)
    {
        try {
            $credential_emails = [
                'email' => $inputs['email'],
                'password' => $inputs['password']
            ];
            $credential_username = [
                'username' => $inputs['email'],
                'password' => $inputs['password']
            ];
            $remember = empty($inputs['remember']) ? false : true;

            if (auth('admin')->attempt($credential_emails, $remember) || auth('admin')->attempt($credential_username, $remember)) {
                if (!auth('admin')->user()->status) {
                    auth('admin')->logout();

                    return [
                        'success' => false,
                        'message' => 'Tài khoản đã bị khóa'
                    ];
                }

                return [
                    'success' => true
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Thông tin đăng nhập sai, vui lòng thử lại'
                ];
            }
        } catch (\Throwable $th) {
            return [
                'success' => false,
                'message' => 'Vui lòng thử lại'
            ];
        }
    }

    public function postForgetPassword($inputs)
    {
        try {
            $checkEmail = $this->userRepository->checkUserByEmail($inputs['email']);

            if (empty($checkEmail)) {
                return [
                    'success' => false,
                    'message' => 'Email không tồn tại'
                ];
            }
            $token = md5(bin2hex(random_bytes(100)));
            DB::beginTransaction();
            DB::table('password_resets')->insert([
                'email' => $inputs['email'],
                'token' => $token
            ]);
            $result = $this->emailService->forgetPassword($inputs['email'], $token, $title = 'Lấy lại mật khẩu');

            if ($result) {
                DB::commit();

                return [
                    'success' => true,
                    'message' => config('const.auth.forget_password')
                ];
            } else {
                DB::rollBack();

                return [
                    'success' => false,
                    'message' => 'Gửi Mail thất bại'
                ];
            }
        } catch (\Throwable $th) {
            DB::rollBack();

            return [
                'success' => false,
                'message' => 'Vui lòng thử lại'
            ];
        }
    }

    public function postResetPassword($inputs, $token)
    {
        try {
            $checkToken = DB::table('password_resets')->where('token', $token)->first();

            if (empty($checkToken)) {
                return [
                    'success' => false,
                    'message' => 'Token không tồn tại'
                ];
            }
            DB::table('password_resets')->where('token', $token)->delete();
            $this->userRepository->updatePassword($checkToken->email, bcrypt($inputs['password']));

            return [
                'success' => true,
                'message' => 'Đổi mật khẩu thành công, vui lòng đăng nhập lại'
            ];
        } catch (\Throwable $th) {
            return [
                'success' => false,
                'message' => 'Vui lòng thử lại'
            ];
        }
    }
}

