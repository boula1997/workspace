<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

/**
 * Sends a plain text WhatsApp message. Drivers (config/services.php -> whatsapp.driver):
 *  - callmebot: free, to your own number (register it once at callmebot.com to get an API key)
 *  - cloud:     WhatsApp Business Cloud API (Meta). Free text only works inside the 24h window,
 *               so set a template for reminders that start the conversation.
 */
class WhatsAppNotifier
{
    // Kept well below the providers' limits; longer messages are sent in several parts
    private const MAX_CHARS = 1500;

    public function send(string $to, string $message): void
    {
        $to = preg_replace('/\D+/', '', $to);
        if ($to === '') {
            throw new RuntimeException('No WhatsApp number to send to.');
        }

        $driver = config('services.whatsapp.driver', 'callmebot');
        foreach ($this->chunks($message) as $part) {
            match ($driver) {
                'callmebot' => $this->sendCallMeBot($to, $part),
                'cloud' => $this->sendCloud($to, $part),
                default => throw new RuntimeException("Unknown WhatsApp driver \"{$driver}\"."),
            };
        }
    }

    /** Splits on line breaks so a task line is never cut in half. */
    public function chunks(string $message): array
    {
        $parts = [];
        $current = '';
        foreach (explode("\n", $message) as $line) {
            if ($current !== '' && mb_strlen($current) + mb_strlen($line) + 1 > self::MAX_CHARS) {
                $parts[] = $current;
                $current = '';
            }
            $current .= ($current === '' ? '' : "\n") . $line;
        }
        if ($current !== '') {
            $parts[] = $current;
        }
        return $parts;
    }

    private function sendCallMeBot(string $to, string $text): void
    {
        $apikey = config('services.whatsapp.callmebot.apikey');
        if (!$apikey) {
            throw new RuntimeException('WHATSAPP_CALLMEBOT_APIKEY is not set.');
        }

        $response = Http::timeout(20)->get('https://api.callmebot.com/whatsapp.php', [
            'phone' => $to,
            'text' => $text,
            'apikey' => $apikey,
        ]);

        if (!$response->successful()) {
            throw new RuntimeException('CallMeBot failed: HTTP ' . $response->status() . ' ' . trim(strip_tags($response->body())));
        }
    }

    private function sendCloud(string $to, string $text): void
    {
        $token = config('services.whatsapp.cloud.token');
        $phoneNumberId = config('services.whatsapp.cloud.phone_number_id');
        if (!$token || !$phoneNumberId) {
            throw new RuntimeException('WHATSAPP_CLOUD_TOKEN and WHATSAPP_CLOUD_PHONE_NUMBER_ID must be set.');
        }

        $template = config('services.whatsapp.cloud.template');
        if ($template) {
            // Template variables cannot hold line breaks
            $payload = [
                'messaging_product' => 'whatsapp',
                'to' => $to,
                'type' => 'template',
                'template' => [
                    'name' => $template,
                    'language' => ['code' => config('services.whatsapp.cloud.language', 'en')],
                    'components' => [[
                        'type' => 'body',
                        'parameters' => [['type' => 'text', 'text' => preg_replace('/\s*\n\s*/', ' • ', $text)]],
                    ]],
                ],
            ];
        } else {
            $payload = [
                'messaging_product' => 'whatsapp',
                'to' => $to,
                'type' => 'text',
                'text' => ['body' => $text],
            ];
        }

        $response = Http::withToken($token)->timeout(20)
            ->post("https://graph.facebook.com/v20.0/{$phoneNumberId}/messages", $payload);

        if (!$response->successful()) {
            throw new RuntimeException('WhatsApp Cloud API failed: HTTP ' . $response->status() . ' ' . $response->body());
        }
    }
}
