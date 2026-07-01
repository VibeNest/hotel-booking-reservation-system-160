<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmtpSetting extends Model
{
    protected $guarded = [];

    public function mailerScheme(): string
    {
        return match ($this->normalizedScheme()) {
            'ssl' => 'smtps',
            default => 'smtp',
        };
    }

    public function mailerEncryption(): ?string
    {
        return match ($this->normalizedScheme()) {
            'tls', 'ssl' => $this->normalizedScheme(),
            default => null,
        };
    }

    public function sanitizedPassword(): string
    {
        return preg_replace('/\s+/', '', (string) $this->password);
    }

    private function normalizedScheme(): ?string
    {
        return $this->scheme ? strtolower(trim($this->scheme)) : null;
    }
}
