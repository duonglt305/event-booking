<?php

namespace DG\Dissertation\Api\Traits;

use Carbon\Carbon;

/**
 * @mixin \Eloquent
 */
trait MakeVerificationCode
{
    public function hasVerifiedEmail(): bool
    {
        return !is_null($this->email_verified_at);
    }

    public function markEmailAsVerified(): void
    {
        $this->update([
            'verify_code' => null,
            'email_verified_at' => Carbon::now()->toDateTimeString(),
        ]);
    }

    public function createVerificationCode(): string
    {
        $verificationCode = $this->createNewVerificationCode();
        $this->insertPayload($this->getPayload($verificationCode));
        return $verificationCode;
    }

    protected function createNewVerificationCode(): string
    {
        return strtoupper(\Str::random(9));
    }

    protected function insertPayload(array $params): void
    {
        $this->update($params);
    }

    protected function getPayload(string $verificationCode): array
    {
        return [
            'verify_code' => \Hash::make($verificationCode),
            'updated_at' => now()->toDateTimeString(),
        ];
    }

    public function validateVerificationCode(string $inputVerificationCode): bool
    {
        return $this->existsVerificationCode($inputVerificationCode);
    }

    protected function existsVerificationCode($inputVerificationCode): bool
    {
        return !$this->verificationCodeExpired($this->updated_at) &&
            $this->assertVerificationCode($inputVerificationCode);
    }

    protected function verificationCodeExpired($updatedAt): bool
    {
        $expires = config('auth.verification.' . $this->getTable() . '.expire') ?? 30;
        return Carbon::parse($updatedAt)->addSeconds($expires * 60)->isPast();
    }

    public function assertVerificationCode($inputVerificationCode): bool
    {
        return \Hash::check($inputVerificationCode, $this->verify_code);
    }
}
