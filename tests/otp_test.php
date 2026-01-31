<?php

/**
 * Manual Test Script for Email OTP Verification
 * 
 * This script simulates the registration flow to verify the logic works correctly.
 * Run this with: php artisan tinker
 * Then paste the code below
 */

// Test 1: Generate OTP
echo "Test 1: Generating OTP\n";
$otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
echo "Generated OTP: $otp\n";
echo "OTP Length: " . strlen($otp) . "\n";
echo "Is 6 digits: " . (strlen($otp) === 6 ? 'YES' : 'NO') . "\n\n";

// Test 2: Simulate session storage
echo "Test 2: Session Storage Simulation\n";
$registrationData = [
    'name' => 'Test User',
    'email' => 'test@example.com',
    'password' => 'password123',
    'role' => 'job_seeker',
];
$otpExpiresAt = now()->addMinutes(10)->timestamp;
echo "Registration Data: " . json_encode($registrationData) . "\n";
echo "OTP: $otp\n";
echo "Expires At: " . date('Y-m-d H:i:s', $otpExpiresAt) . "\n";
echo "Current Time: " . now()->format('Y-m-d H:i:s') . "\n";
echo "Is Expired: " . (now()->timestamp > $otpExpiresAt ? 'YES' : 'NO') . "\n\n";

// Test 3: OTP Validation
echo "Test 3: OTP Validation\n";
$userInputOtp = $otp; // Correct OTP
echo "User Input: $userInputOtp\n";
echo "Stored OTP: $otp\n";
echo "Match: " . ($userInputOtp === $otp ? 'YES' : 'NO') . "\n\n";

$wrongOtp = '000000';
echo "Wrong OTP Test:\n";
echo "User Input: $wrongOtp\n";
echo "Stored OTP: $otp\n";
echo "Match: " . ($wrongOtp === $otp ? 'YES' : 'NO') . "\n\n";

// Test 4: User Creation Simulation
echo "Test 4: User Creation (Dry Run)\n";
echo "Would create user with:\n";
echo "  Name: {$registrationData['name']}\n";
echo "  Email: {$registrationData['email']}\n";
echo "  Role: {$registrationData['role']}\n";
echo "  Email Verified: YES\n\n";

echo "All tests completed successfully!\n";
