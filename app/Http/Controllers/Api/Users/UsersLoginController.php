<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\Users;

use App\Models\User;
use App\Models\VerificationCode;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Enums\Version;
use Illuminate\Http\{JsonResponse, Request};

use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Api\v1_0\UserStoreRequest;
use Exception;
use Illuminate\Validation\Rule;
use App\Http\Resources\v1_0\UserResource;


class UsersLoginController extends Controller
{
    public function sendVerificationCode(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
        ]);
    
        $email = $validatedData['email'];
    
        $verificationCode = str_pad((string)mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
    
        $msg = 'Your verification code for Daily Rant is: ' . $verificationCode;
        $isMailSend = sendEmailWithTryCatch($email, $msg, 'Verification Code', 'emails.verification_code', null);
    
        if ($isMailSend) {
            // Log email sending status
            \Log::info('Email sent successfully to: ' . $email);
    
            $verificationCode = VerificationCode::updateOrCreate(
                ['email' => $email],
                ['code' => $verificationCode]
            );
            $responseData = [
                'success' => true,
                'message' => 'Code sent successfully, Please check your email'
            ];
        } else {
            // Log email sending failure
            \Log::error('Failed to send email to: ' . $email);
    
            $responseData = [
                'success' => false,
                'message' => 'Failed to send the email.'
            ];
        }
    
        return response()->json($responseData);
    }
    

    public function verifyCode(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'email' => 'required|email',
                'code' => 'required|string'
            ]);

            $email = $validatedData['email'];
            $codes = $validatedData['code'];

            $code = intval($codes);

            // Check if the verification code exists for the given email
            $verificationCode = VerificationCode::where('email', $email)
                ->where('code', $code)
                ->first();

            if ($verificationCode) {
                $responseData = ['success' => true];

                $user = User::where('email', $email)
                    ->first();

                if ($user) {

                    $responseData['user'] = $user;
                    $token = $user->createToken('auth')->plainTextToken;
                    $responseData['token'] = $token;
                } else {
                    $responseData['user'] = null;
                }

                return response()->json($responseData);
            } else {
                return response()->json(['success' => false, 'message' => 'Invalid code or email.'], 400);
            }
        } catch (\Exception $e) {
            // Handle other exceptions (e.g., database errors) and log them.
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return response()->json(['message' => 'An error occurred while verifying the code.'], 500);
        }
    }

    public function loginWithEmailAndPassword(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        $user = User::where('email', $validatedData['email'])
            ->first();
        if ($user) {
            if (!Hash::check($validatedData['password'], $user->password)) {
                throw ValidationException::withMessages([
                    'password' => [(string) trans('validation.credentials')],
                ]);
            }

            $token = $user->createToken('auth')->plainTextToken;

            $responseData = [
                'success' => true,
                'token' => $token,
                'data' => $user,
            ];
        } else {
            $responseData = [
                'success' => false,
                'message' => 'Admin does not exist',
            ];
        }
        return response()->json($responseData);
    }

}
