<?php


namespace DG\Dissertation\Admin\Api\Traits;


use Carbon\Carbon;
use Hash;
use Illuminate\Database\Eloquent\Model;
use Str;
use function Illuminate\Support\Facades\Hash;

/**
 * Trait CanMakeVerificationCode
 * @package DG\Dissertation\Admin\Api\Traits
 * @mixin Model
 */
trait CanMakeVerificationCode
{
    /**
     * @param $email
     * @return false|string
     */
    public function createVerificationCode($email): string
    {
        $this->deleteExisting($email);

        $verificationCode = $this->createNewVerificationCode();

        $this->insertPayload($this->getPayload($email, $verificationCode));

        return $verificationCode;
    }

    /**
     * @param $email
     */
    protected function deleteExisting($email): void
    {
        $this->newQuery()->where('email', '=', $email)->update(['']);
    }

    /**
     * @return false|string
     */
    protected function createNewVerificationCode(): string
    {
        return Hash::make(Str::random(9));
    }

    /**
     * @param array $params
     */
    protected function insertPayload(array $params): void
    {
        $this->newQuery()->update($params);
    }

    /**
     * @param $email
     * @param $verificationCode
     * @return array
     */
    protected function getPayload($email, $verificationCode): array
    {
        return [
            'email' => $email,
            'verify_code' => $verificationCode,
            'updated_at' => now()->toDateTimeString(),
        ];
    }

    /**
     * @param array $params
     * @return bool
     */
    public function validateVerificationCode(array $params): bool
    {
        return $this->existsVerificationCode($params);
    }

    /**
     * @param array $params
     * @return bool
     */
    protected function existsVerificationCode(array $params): bool
    {
        $record = $this->newQuery()->where('email', '=', $params['email'])->first();
        return $record &&
            !$this->verificationCodeExpired($record->created_at) &&
            Hash::check($params['verification_code'], $record['verification_code']);
    }

    /**
     * @param $updatedAt
     * @return bool
     */
    protected function verificationCodeExpired($updatedAt)
    {
        return Carbon::parse($updatedAt)->addSeconds(config('auth.verification.attendees.expires') * 60)->isPast();
    }

}
