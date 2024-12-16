<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Packages;
use App\Models\User;
use App\Models\Verification;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $mobile = $request->mobile;
        // Attempt to retrieve the first user with the provided mobile number
        $user = User::where('mobile', $mobile)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $localOtp = rand(1000, 9999);
        // Format the mobile number with country code
        $formattedMobile = "{$user->country_code}{$user->mobile}";

        // Delete any existing verifications for this user
        Verification::where(['mobile' => $user->mobile, 'country_code' => $user->country_code])->delete();

        // Create a new verification record
        Verification::create([
            'mobile' => $user->mobile,
            'otp' => $localOtp,
            'country_code' => $user->country_code,
        ]);

        // Webhook URL for sending OTP via HTTP request
        $url = 'https://webhooks.wappblaster.com/webhook/669b736a97d275a0b8012769';
        $response = Http::get($url, [
            'number' => $formattedMobile,
            'otp' => $localOtp,
        ]);

        // Respond with appropriate message
        return response()->json(['message' => 'OTP sent successfully', 'response' => $response->body()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'mobile' => ['required', 'digits:10', 'regex:/^[0-9]{10}$/'],
            'otp' => ['required', 'digits:4'],
            'device_id' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Retrieve validated data
        $data = $validator->validated();

        // Check for matching mobile and OTP in Verification table
        $query = Verification::where('mobile', $data['mobile'])
            ->where('otp', $data['otp'])
            ->first();

        if ($query) {
            // Find the user and log in using the user's ID
            $user = User::where('mobile', $data['mobile'])->first();
            $package = Packages::find($user->package_id);
            if ($user) {
                Auth::loginUsingId($user->id);

                // Generate an access token for the authenticated user
                $token = $user->createToken('authToken')->plainTextToken;
                $query->delete();
                $expiryDate = Carbon::createFromFormat('Y-m-d', $user->expiry_date);
                $today = Carbon::now();

                // Check if the expiry date has passed
                $isExpired = $expiryDate->isPast();

                // Calculate days left until expiration
                $daysLeft = round($today->diffInDays($expiryDate, false)); // false to get negative values if past

                $newData = [
                    "icon" => asset('/storage/' . $user->logo),
                    "whitelabelname" => $user->software_name,
                    "currentsoftwareversion" => config('app.softwareversion'),
                    "isexpired" => $isExpired,
                    "daysleft" => $daysLeft,
                    "updatesoftwarelink" => config('app.softwareupdateurl'),
                    "device_id" => $user->device_id,
                ];
                if ($request->device_id) {
                    $user->update(['device_id' => $request->device_id]);
                }

                return response()->json([
                    'status' => JsonResponse::HTTP_OK,
                    'token' => $token,
                    'message' => 'OTP Verified successfully!',
                    'user' => Auth::user(),
                    'package' => $package,
                    'data' => $newData,
                ], JsonResponse::HTTP_OK);
            }

            return response()->json([
                'status' => JsonResponse::HTTP_UNAUTHORIZED,
                'message' => 'User not found.',
            ], JsonResponse::HTTP_UNAUTHORIZED);
        } else {
            return response()->json([
                'status' => JsonResponse::HTTP_UNAUTHORIZED,
                'message' => 'Invalid OTP. Try again!',
            ], JsonResponse::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
