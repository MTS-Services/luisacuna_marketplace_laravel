<?php
// File: app/Helpers/helpers.php (Add to existing helpers file)

use Carbon\Carbon;
use App\Enums\OtpType;
use App\Models\Currency;
use Illuminate\Support\Str;
use App\Models\OtpVerification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

// ==================== Existing Auth Helpers ====================

if (!function_exists('timeFormat')) {
    function timeFormat($time, $compareValue = null)
    {
        return $time && $time != $compareValue ? date(('H:i A'), strtotime($time)) : 'N/A';
    }
}

if (!function_exists('dateFormat')) {
    function dateFormat($date, $compareValue = null)
    {
        return $date && $date != $compareValue ? date(('d M Y'), strtotime($date)) : 'N/A';
    }
}
if (!function_exists('dateTimeFormat')) {
    function dateTimeFormat($dateTime, $compareValue = null)
    {
        return $dateTime && $dateTime != $compareValue ? dateFormat($dateTime) . ' ' . timeFormat($dateTime) : 'N/A';
    }
}
if (!function_exists('dateTimeHumanFormat')) {
    function dateTimeHumanFormat($dateTime, $compareValue = null): mixed
    {
        return $dateTime && $dateTime != $compareValue ? Carbon::parse($dateTime)->diffForHumans() : 'N/A';
    }
}

if (!function_exists('isLoggedIn')) {

    function isLoggedIn()
    {
        return Auth::check();
    }
}

if (!function_exists('user')) {
    function user()
    {
        return Auth::guard('web')->user();
    }
}

if (!function_exists('admin')) {
    function admin()
    {
        return Auth::guard('admin')->user();
    }
}

// ==================== Existing Storage Helpers ====================

if (!function_exists('storage_url')) {
    function storage_url($urlOrArray)
    {
        $image = asset('assets/images/no_img.jpg');

        if (is_array($urlOrArray) || is_object($urlOrArray)) {
            $result = '';
            $count = 0;
            $itemCount = count($urlOrArray);

            foreach ($urlOrArray as $index => $url) {

                $result .= $url
                    ? (Str::startsWith($url, ['http://', 'https://'])
                        ? $url
                        : asset('storage/' . $url))
                    : $image;

                $result .= ($count === $itemCount - 1) ? '' : ', ';
                $count++;
            }

            return $result;
        } else {

            return $urlOrArray
                ? (Str::startsWith($urlOrArray, ['http://', 'https://'])
                    ? $urlOrArray
                    : asset('storage/' . $urlOrArray))
                : $image;
        }
    }
}


if (!function_exists('auth_storage_url')) {
    function auth_storage_url($url)
    {
        $image = asset('assets/images/default_profile.jpg');

        return $url
            ? (Str::startsWith($url, ['http://', 'https://'])
                ? $url
                : asset('storage/' . $url))
            : $image;
    }
}





// ==================== Existing Application Setting Helpers ====================

// ==================== NEW OTP Helpers ====================

if (!function_exists('generate_otp')) {
    /**
     * Generate a random OTP code
     *
     * @param int $digits Number of digits (default: 6)
     * @return string
     */
    function generate_otp(int $digits = 6): string
    {
        $min = pow(10, $digits - 1);
        $max = pow(10, $digits) - 1;
        return (string) mt_rand($min, $max);
    }
}

if (!function_exists('create_otp')) {
    /**
     * Create OTP for a model
     *
     * @param mixed $model Model instance (Admin, User, etc.)
     * @param OtpType $type OTP type
     * @param int $expiresInMinutes Expiration time in minutes
     * @return OtpVerification
     */
    function create_otp($model, OtpType $type, int $expiresInMinutes = 10): OtpVerification
    {
        return $model->createOtp($type, $expiresInMinutes);
    }
}

if (!function_exists('verify_otp')) {
    /**
     * Verify OTP code for a model
     *
     * @param mixed $model Model instance
     * @param string $code OTP code to verify
     * @param OtpType $type OTP type
     * @return bool
     */
    function verify_otp($model, string $code, OtpType $type): bool
    {
        $otp = $model->latestOtp($type);

        if (!$otp) {
            return false;
        }

        return $otp->verify($code);
    }
}

if (!function_exists('has_valid_otp')) {
    /**
     * Check if model has valid unexpired OTP
     *
     * @param mixed $model Model instance
     * @param OtpType $type OTP type
     * @return bool
     */
    function has_valid_otp($model, OtpType $type): bool
    {
        $otp = $model->latestOtp($type);

        if (!$otp) {
            return false;
        }

        return !$otp->isExpired() && !$otp->isVerified();
    }
}

if (!function_exists('get_otp_remaining_time')) {
    /**
     * Get remaining time for OTP expiration in seconds
     *
     * @param mixed $model Model instance
     * @param OtpType $type OTP type
     * @return int|null Remaining seconds or null
     */
    function get_otp_remaining_time($model, OtpType $type): ?int
    {
        $otp = $model->latestOtp($type);

        if (!$otp || $otp->isExpired()) {
            return null;
        }

        return max(0, $otp->expires_at->diffInSeconds(now()));
    }
}

if (!function_exists('format_otp_time')) {
    /**
     * Format OTP remaining time in human-readable format
     *
     * @param int|null $seconds
     * @return string
     */
    function format_otp_time(?int $seconds): string
    {
        if (!$seconds || $seconds <= 0) {
            return 'Expired';
        }

        if ($seconds < 60) {
            return $seconds . ' second' . ($seconds > 1 ? 's' : '');
        }

        $minutes = floor($seconds / 60);
        $remainingSeconds = $seconds % 60;

        if ($remainingSeconds > 0) {
            return $minutes . ' minute' . ($minutes > 1 ? 's' : '') . ' ' .
                $remainingSeconds . ' second' . ($remainingSeconds > 1 ? 's' : '');
        }

        return $minutes . ' minute' . ($minutes > 1 ? 's' : '');
    }
}

if (!function_exists('is_email_verified')) {
    /**
     * Check if user/admin email is verified
     *
     * @param mixed $model
     * @return bool
     */
    function is_email_verified($model): bool
    {
        return !is_null($model?->email_verified_at);
    }
}

if (!function_exists('is_phone_verified')) {
    /**
     * Check if user/admin phone is verified
     *
     * @param mixed $model
     * @return bool
     */
    function is_phone_verified($model): bool
    {
        return !is_null($model?->phone_verified_at);
    }
}
if (!function_exists('availableTimezones')) {
    function availableTimezones()
    {
        $timezones = [];
        $timezoneIdentifiers = DateTimeZone::listIdentifiers();

        foreach ($timezoneIdentifiers as $timezoneIdentifier) {
            $timezone = new DateTimeZone($timezoneIdentifier);
            $offset = $timezone->getOffset(new DateTime());
            $offsetPrefix = $offset < 0 ? '-' : '+';
            $offsetFormatted = gmdate('H:i', abs($offset));

            $timezones[] = [
                'timezone' => $timezoneIdentifier,
                'name' => "(UTC $offsetPrefix$offsetFormatted) $timezoneIdentifier",
            ];
        }

        return $timezones;
    }
}

if (!function_exists('gameCategories')) {
    function gameCategories()
    {
        return [
            [
                'name' => 'Currency',
                'slug' => 'currency',
                'url' => route('currency'),
                'games' => [
                    'popular' => [
                        ['name' => 'New World Coins', 'icon' => 'Frame 100.png', 'slug' => 'new-world-coins'],
                        ['name' => 'Worldforge Legends', 'icon' => 'Frame 94.png', 'slug' => 'worldforge-legends'],
                        ['name' => 'Exilecon Official Trailer', 'icon' => 'Frame 93.png', 'slug' => 'exilecon-official-trailer'],
                        ['name' => 'Echoes of the Terra', 'icon' => 'Frame 96.png', 'slug' => 'echoes-of-the-terra'],
                        ['name' => 'Path of Exile 2 Currency', 'icon' => 'Frame 103.png', 'slug' => 'path-of-exile-2-currency'],
                        ['name' => 'Epochs of Gaia', 'icon' => 'Frame 102.png', 'slug' => 'epochs-of-gaia'],
                        ['name' => 'Throne and Liberty Lucent', 'icon' => 'Frame 105.png', 'slug' => 'throne-and-liberty-lucent'],
                        ['name' => 'Titan Realms', 'icon' => 'Frame 98.png', 'slug' => 'titan-realms'],
                        ['name' => 'Blade Ball Tokens', 'icon' => 'Frame 97.png', 'slug' => 'blade-ball-tokens'],
                        ['name' => 'Kingdoms Across Skies', 'icon' => 'Frame 99.png', 'slug' => 'kingdoms-across-skies'],
                        ['name' => 'EA Sports FC Coins', 'icon' => 'Frame1001.png', 'slug' => 'ea-sports-fc-coins'],
                        ['name' => 'Realmwalker: New Dawn', 'icon' => 'Frame 111.png', 'slug' => 'realmwalker-new-dawn'],
                    ],
                    'all' => [
                        'EA Sports FC Coins',
                        'Albion Online Silver',
                        'Animal Crossing: New Horizons Bells',
                        'Black Desert Online Silver',
                        'Blade & Soul NEO Divine Gems',
                        'Blade Ball Tokens',
                    ]
                ]
            ],
            [
                'name' => 'Gift Card',
                'slug' => 'gift-card',
                'url' => route('gift-card'),
                'games' => [
                    'popular' => [
                        ['name' => 'New World Coins', 'icon' => 'Frame 100.png', 'slug' => 'new-world-coins'],
                        ['name' => 'Worldforge Legends', 'icon' => 'Frame 94.png', 'slug' => 'worldforge-legends'],
                        ['name' => 'Exilecon Official Trailer', 'icon' => 'Frame 93.png', 'slug' => 'exilecon-official-trailer'],
                        ['name' => 'Echoes of the Terra', 'icon' => 'Frame 96.png', 'slug' => 'echoes-of-the-terra'],
                        ['name' => 'Path of Exile 2 Currency', 'icon' => 'Frame 103.png', 'slug' => 'path-of-exile-2-currency'],
                        ['name' => 'Epochs of Gaia', 'icon' => 'Frame 102.png', 'slug' => 'epochs-of-gaia'],
                        ['name' => 'Throne and Liberty Lucent', 'icon' => 'Frame 105.png', 'slug' => 'throne-and-liberty-lucent'],
                        ['name' => 'Titan Realms', 'icon' => 'Frame 98.png', 'slug' => 'titan-realms'],
                        ['name' => 'Blade Ball Tokens', 'icon' => 'Frame 97.png', 'slug' => 'blade-ball-tokens'],
                        ['name' => 'Kingdoms Across Skies', 'icon' => 'Frame 99.png', 'slug' => 'kingdoms-across-skies'],
                        ['name' => 'EA Sports FC Coins', 'icon' => 'Frame1001.png', 'slug' => 'ea-sports-fc-coins'],
                        ['name' => 'Realmwalker: New Dawn', 'icon' => 'Frame 111.png', 'slug' => 'realmwalker-new-dawn'],
                    ],
                    'all' => [
                        'EA Sports FC Coins',
                        'Albion Online Silver',
                        'Animal Crossing: New Horizons Bells',
                        'Black Desert Online Silver',
                        'Blade & Soul NEO Divine Gems',
                        'Blade Ball Tokens',
                    ]
                ]
            ],
            [
                'name' => 'Boosting',
                'slug' => 'boosting',
                'url' => route('boosting'),
                'games' => [
                    'popular' => [
                        ['name' => 'New World Coins', 'icon' => 'Frame 100.png', 'slug' => 'new-world-coins'],
                        ['name' => 'Worldforge Legends', 'icon' => 'Frame 94.png', 'slug' => 'worldforge-legends'],
                        ['name' => 'Exilecon Official Trailer', 'icon' => 'Frame 93.png', 'slug' => 'exilecon-official-trailer'],
                        ['name' => 'Echoes of the Terra', 'icon' => 'Frame 96.png', 'slug' => 'echoes-of-the-terra'],
                        ['name' => 'Path of Exile 2 Currency', 'icon' => 'Frame 103.png', 'slug' => 'path-of-exile-2-currency'],
                        ['name' => 'Epochs of Gaia', 'icon' => 'Frame 102.png', 'slug' => 'epochs-of-gaia'],
                        ['name' => 'Throne and Liberty Lucent', 'icon' => 'Frame 105.png', 'slug' => 'throne-and-liberty-lucent'],
                        ['name' => 'Titan Realms', 'icon' => 'Frame 98.png', 'slug' => 'titan-realms'],
                        ['name' => 'Blade Ball Tokens', 'icon' => 'Frame 97.png', 'slug' => 'blade-ball-tokens'],
                        ['name' => 'Kingdoms Across Skies', 'icon' => 'Frame 99.png', 'slug' => 'kingdoms-across-skies'],
                        ['name' => 'EA Sports FC Coins', 'icon' => 'Frame1001.png', 'slug' => 'ea-sports-fc-coins'],
                        ['name' => 'Realmwalker: New Dawn', 'icon' => 'Frame 111.png', 'slug' => 'realmwalker-new-dawn'],
                    ],
                    'all' => [
                        'EA Sports FC Coins',
                        'Albion Online Silver',
                        'Animal Crossing: New Horizons Bells',
                        'Black Desert Online Silver',
                        'Blade & Soul NEO Divine Gems',
                        'Blade Ball Tokens',
                    ]
                ]
            ],
            [
                'name' => 'Items',
                'slug' => 'items',
                'url' => route('items'),
                'games' => [
                    'popular' => [
                        ['name' => 'New World Coins', 'icon' => 'Frame 100.png', 'slug' => 'new-world-coins'],
                        ['name' => 'Worldforge Legends', 'icon' => 'Frame 94.png', 'slug' => 'worldforge-legends'],
                        ['name' => 'Exilecon Official Trailer', 'icon' => 'Frame 93.png', 'slug' => 'exilecon-official-trailer'],
                        ['name' => 'Echoes of the Terra', 'icon' => 'Frame 96.png', 'slug' => 'echoes-of-the-terra'],
                        ['name' => 'Path of Exile 2 Currency', 'icon' => 'Frame 103.png', 'slug' => 'path-of-exile-2-currency'],
                        ['name' => 'Epochs of Gaia', 'icon' => 'Frame 102.png', 'slug' => 'epochs-of-gaia'],
                        ['name' => 'Throne and Liberty Lucent', 'icon' => 'Frame 105.png', 'slug' => 'throne-and-liberty-lucent'],
                        ['name' => 'Titan Realms', 'icon' => 'Frame 98.png', 'slug' => 'titan-realms'],
                        ['name' => 'Blade Ball Tokens', 'icon' => 'Frame 97.png', 'slug' => 'blade-ball-tokens'],
                        ['name' => 'Kingdoms Across Skies', 'icon' => 'Frame 99.png', 'slug' => 'kingdoms-across-skies'],
                        ['name' => 'EA Sports FC Coins', 'icon' => 'Frame1001.png', 'slug' => 'ea-sports-fc-coins'],
                        ['name' => 'Realmwalker: New Dawn', 'icon' => 'Frame 111.png', 'slug' => 'realmwalker-new-dawn'],
                    ],
                    'all' => [
                        'EA Sports FC Coins',
                        'Albion Online Silver',
                        'Animal Crossing: New Horizons Bells',
                        'Black Desert Online Silver',
                        'Blade & Soul NEO Divine Gems',
                        'Blade Ball Tokens',
                    ]
                ]
            ],
            [
                'name' => 'Accounts',
                'slug' => 'accounts',
                'url' => route('accounts'),
                'games' => [
                    'popular' => [
                        ['name' => 'New World Coins', 'icon' => 'Frame 100.png', 'slug' => 'new-world-coins'],
                        ['name' => 'Worldforge Legends', 'icon' => 'Frame 94.png', 'slug' => 'worldforge-legends'],
                        ['name' => 'Exilecon Official Trailer', 'icon' => 'Frame 93.png', 'slug' => 'exilecon-official-trailer'],
                        ['name' => 'Echoes of the Terra', 'icon' => 'Frame 96.png', 'slug' => 'echoes-of-the-terra'],
                        ['name' => 'Path of Exile 2 Currency', 'icon' => 'Frame 103.png', 'slug' => 'path-of-exile-2-currency'],
                        ['name' => 'Epochs of Gaia', 'icon' => 'Frame 102.png', 'slug' => 'epochs-of-gaia'],
                        ['name' => 'Throne and Liberty Lucent', 'icon' => 'Frame 105.png', 'slug' => 'throne-and-liberty-lucent'],
                        ['name' => 'Titan Realms', 'icon' => 'Frame 98.png', 'slug' => 'titan-realms'],
                        ['name' => 'Blade Ball Tokens', 'icon' => 'Frame 97.png', 'slug' => 'blade-ball-tokens'],
                        ['name' => 'Kingdoms Across Skies', 'icon' => 'Frame 99.png', 'slug' => 'kingdoms-across-skies'],
                        ['name' => 'EA Sports FC Coins', 'icon' => 'Frame1001.png', 'slug' => 'ea-sports-fc-coins'],
                        ['name' => 'Realmwalker: New Dawn', 'icon' => 'Frame 111.png', 'slug' => 'realmwalker-new-dawn'],
                    ],
                    'all' => [
                        'EA Sports FC Coins',
                        'Albion Online Silver',
                        'Animal Crossing: New Horizons Bells',
                        'Black Desert Online Silver',
                        'Blade & Soul NEO Divine Gems',
                        'Blade Ball Tokens',
                    ]
                ]
            ],
            [
                'name' => 'Top Up',
                'slug' => 'top-up',
                'url' => route('top-up'),
                'games' => [
                    'popular' => [
                        ['name' => 'New World Coins', 'icon' => 'Frame 100.png', 'slug' => 'new-world-coins'],
                        ['name' => 'Worldforge Legends', 'icon' => 'Frame 94.png', 'slug' => 'worldforge-legends'],
                        ['name' => 'Exilecon Official Trailer', 'icon' => 'Frame 93.png', 'slug' => 'exilecon-official-trailer'],
                        ['name' => 'Echoes of the Terra', 'icon' => 'Frame 96.png', 'slug' => 'echoes-of-the-terra'],
                        ['name' => 'Path of Exile 2 Currency', 'icon' => 'Frame 103.png', 'slug' => 'path-of-exile-2-currency'],
                        ['name' => 'Epochs of Gaia', 'icon' => 'Frame 102.png', 'slug' => 'epochs-of-gaia'],
                        ['name' => 'Throne and Liberty Lucent', 'icon' => 'Frame 105.png', 'slug' => 'throne-and-liberty-lucent'],
                        ['name' => 'Titan Realms', 'icon' => 'Frame 98.png', 'slug' => 'titan-realms'],
                        ['name' => 'Blade Ball Tokens', 'icon' => 'Frame 97.png', 'slug' => 'blade-ball-tokens'],
                        ['name' => 'Kingdoms Across Skies', 'icon' => 'Frame 99.png', 'slug' => 'kingdoms-across-skies'],
                        ['name' => 'EA Sports FC Coins', 'icon' => 'Frame1001.png', 'slug' => 'ea-sports-fc-coins'],
                        ['name' => 'Realmwalker: New Dawn', 'icon' => 'Frame 111.png', 'slug' => 'realmwalker-new-dawn'],
                    ],
                    'all' => [
                        'EA Sports FC Coins',
                        'Albion Online Silver',
                        'Animal Crossing: New Horizons Bells',
                        'Black Desert Online Silver',
                        'Blade & Soul NEO Divine Gems',
                        'Blade Ball Tokens',
                    ]
                ]
            ],
            [
                'name' => 'Coaching',
                'slug' => 'coaching',
                'url' => route('coaching'),
                'games' => [
                    'popular' => [
                        ['name' => 'New World Coins', 'icon' => 'Frame 100.png', 'slug' => 'new-world-coins'],
                        ['name' => 'Worldforge Legends', 'icon' => 'Frame 94.png', 'slug' => 'worldforge-legends'],
                        ['name' => 'Exilecon Official Trailer', 'icon' => 'Frame 93.png', 'slug' => 'exilecon-official-trailer'],
                        ['name' => 'Echoes of the Terra', 'icon' => 'Frame 96.png', 'slug' => 'echoes-of-the-terra'],
                        ['name' => 'Path of Exile 2 Currency', 'icon' => 'Frame 103.png', 'slug' => 'path-of-exile-2-currency'],
                        ['name' => 'Epochs of Gaia', 'icon' => 'Frame 102.png', 'slug' => 'epochs-of-gaia'],
                        ['name' => 'Throne and Liberty Lucent', 'icon' => 'Frame 105.png', 'slug' => 'throne-and-liberty-lucent'],
                        ['name' => 'Titan Realms', 'icon' => 'Frame 98.png', 'slug' => 'titan-realms'],
                        ['name' => 'Blade Ball Tokens', 'icon' => 'Frame 97.png', 'slug' => 'blade-ball-tokens'],
                        ['name' => 'Kingdoms Across Skies', 'icon' => 'Frame 99.png', 'slug' => 'kingdoms-across-skies'],
                        ['name' => 'EA Sports FC Coins', 'icon' => 'Frame1001.png', 'slug' => 'ea-sports-fc-coins'],
                        ['name' => 'Realmwalker: New Dawn', 'icon' => 'Frame 111.png', 'slug' => 'realmwalker-new-dawn'],
                    ],
                    'all' => [
                        'EA Sports FC Coins',
                        'Albion Online Silver',
                        'Animal Crossing: New Horizons Bells',
                        'Black Desert Online Silver',
                        'Blade & Soul NEO Divine Gems',
                        'Blade Ball Tokens',
                    ]
                ]
            ]
        ];
    }
}

if (!function_exists('getAuditorName')) {
    function getAuditorName($model)
    {
        return $model && $model->name ? $model->name : (isset($model->first_name) ? $model->first_name . ' ' . $model->last_name : 'N/A');
    }
}


if (!function_exists('log_error')) {
    function log_error($e): void
    {
        Log::error(
            'LOG ERROR DATA: ' . [
                "Error" => $e->getMessage(),
                "Trace" => $e->getTraceAsString(),
                "Data" => [
                    "File" => $e->getFile(),
                    "Line" => $e->getLine()
                ],
                "Request" => [
                    "URL" => request()->fullUrl(),
                    "Method" => request()->method(),
                    "IP" => request()->ip(),
                    "Input"  => json_encode(request()->all(), JSON_UNESCAPED_UNICODE),
                ]
            ]
        );
    }
}

if (!function_exists('log_info')) {
    function log_info($i, $data = []): void
    {
        Log::info(
            'LOG INFO DATA: ' . [
                "Info" => $i,
                "Data" => json_encode($data, JSON_UNESCAPED_UNICODE)
            ]
        );
    }
}


if (!function_exists('category_route')) {
    /**
     * Get the route URL based on category slug
     *
     * @param string $slug
     * @return string
     */
    function category_route(string $slug): string
    {
        $routes = [
            'currency'   => 'currency',
            'gift-card'  => 'gift-card',
            'boosting'   => 'boosting',
            'items'      => 'items',
            'accounts'   => 'accounts',
            'top-up'     => 'top-up',
            'coaching'   => 'coaching',
        ];

        return isset($routes[$slug]) ? route($routes[$slug]) : '#';
    }
}


if (!function_exists('currency_exchange')) {
    function currency_exchange($price)
    {
        $defaultCurrency = Currency::where('is_default', true)->first();

        if (!$defaultCurrency) {
            return $price;
        }
        $selectedCurrencyCode = session('currency', $defaultCurrency->code);

        $selectedCurrency = Currency::where('code', $selectedCurrencyCode)->first();

        if (!$selectedCurrency) {
            return $price;
        }
        $convertedAmount = $price * ($selectedCurrency->exchange_rate / $defaultCurrency->exchange_rate);
        return $convertedAmount;
    }
}


if (!function_exists('currency_symbol')) {
    function currency_symbol()
    {
        $defaultCurrency = Currency::where('is_default', true)->first();

        if (!$defaultCurrency) {
            return '';
        }

        $selectedCurrencyCode = session('currency', $defaultCurrency->code);

        $selectedCurrency = Currency::where('code', $selectedCurrencyCode)->first();

        return $selectedCurrency?->symbol ?? '';
    }
}




if (!function_exists('number_shorten')) {
    /**
     * Shorten a number to a human-readable format.
     * 
     * @param int|float $number The number to shorten
     * @param int $precision The number of decimal places to round to
     * @return string The shortened number
     * 
     * Examples:
     * number_shorten(1234) // 1.2k
     * number_shorten(1234567) // 1.2M
     * number_shorten(1234567890) // 1.2B
     * number_shorten(1234567890123) // 1.2T
     */
    function number_shorten($number, $precision = 1)
    {
        if ($number < 900) {
            // 0 - 900
            $number_format = number_format($number, $precision);
            $suffix = '';
        } elseif ($number < 900000) {
            // 0.9k-850k
            $number_format = number_format($number / 1000, $precision);
            $suffix = 'k';
        } elseif ($number < 900000000) {
            // 0.9m-850m
            $number_format = number_format($number / 1000000, $precision);
            $suffix = 'M';
        } elseif ($number < 900000000000) {
            // 0.9b-850b
            $number_format = number_format($number / 1000000000, $precision);
            $suffix = 'B';
        } else {
            // 0.9t+
            $number_format = number_format($number / 1000000000000, $precision);
            $suffix = 'T';
        }

        // Remove unnecessary .0
        if ($precision > 0) {
            $dotzero = '.' . str_repeat('0', $precision);
            $number_format = str_replace($dotzero, '', $number_format);
        }

        return $number_format . $suffix;
    }
}
