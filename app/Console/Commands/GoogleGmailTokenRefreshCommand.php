<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;
use TomShaw\GoogleApi\GoogleClient;
use TomShaw\GoogleApi\Models\GoogleToken;

class GoogleGmailTokenRefreshCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'google:gmail-token-refresh {--user= : User id or e-mail address} {--force : Refresh all matching tokens}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh Gmail OAuth tokens before they expire.';

    /**
     * Execute the console command.
     */
    public function handle(GoogleClient $client): int
    {
        $tokens = GoogleToken::whereNotNull('refresh_token')
            ->when($this->option('user'), function ($query, $user) {
                if (is_numeric($user)) {
                    return $query->where('user_id', $user);
                }

                $userModel = User::where('email', $user)->first();

                return $query->where('user_id', $userModel?->id ?? 0);
            })
            ->get();

        if ($tokens->isEmpty()) {
            $this->info('No Google tokens found.');

            return self::SUCCESS;
        }

        $failed = false;

        foreach ($tokens as $token) {
            if (! $this->option('force') && ! $this->expiresSoon($token)) {
                continue;
            }

            $user = User::find($token->user_id);

            if (! $user) {
                $failed = true;
                $this->error('User not found for Google token '.$token->id.'.');

                continue;
            }

            Auth::login($user);

            try {
                $accessToken = $client->fetchAccessTokenWithRefreshToken($token->refresh_token);

                if (is_array($accessToken)) {
                    $client->setAccessToken($accessToken);
                    $this->info('Refreshed Google token for '.$user->email.'.');
                }
            } catch (Throwable $exception) {
                $failed = true;
                Log::error('Unable to refresh Google token for '.$user->email.': '.$exception->getMessage());
                $this->error('Unable to refresh Google token for '.$user->email.'.');
            } finally {
                Auth::logout();
            }
        }

        return $failed ? self::FAILURE : self::SUCCESS;
    }

    private function expiresSoon(GoogleToken $token): bool
    {
        if (! $token->created || ! $token->expires_in) {
            return true;
        }

        return ((int) $token->created + (int) $token->expires_in) <= now()->addMinutes(30)->timestamp;
    }
}
