use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;



// Check if 'Doku' identifier already exists in the payment_gateways table
$doku = DB::table('payment_gateways')->where('identifier', 'doku')->first();

if (!$doku) {
    // Insert if not exists
    DB::table('payment_gateways')->insert([
        'identifier' => 'doku',
        'currency' => 'IDR',
        'title' => 'Doku',
        'model_name' => 'Doku',
        'description' => null,
        'keys' => json_encode([
            'client_id' => 'BRN-xxxx-xxxxxxxxxxxxx',
            'secret_test_key' => 'SK-xxxxxxxxxxxxxxxxxxxx',
            'public_test_key' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
            'secret_live_key' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
            'public_live_key' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
        ]),
        'status' => 1,
        'test_mode' => 1,
        'is_addon' => 0,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
} else {
    // Update existing keys if needed
    $keys = json_decode($doku->keys, true);
    $updated = false;

    if (!isset($keys['secret_live_key'])) {
        $keys['secret_live_key'] = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
        $updated = true;
    }

    if (!isset($keys['public_live_key'])) {
        $keys['public_live_key'] = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
        $updated = true;
    }

    if ($updated) {
        DB::table('payment_gateways')->where('id', $doku->id)->update([
            'keys' => json_encode($keys),
            'updated_at' => now(),
        ]);
    }
}


$s3_config = [
    'active' => null,
    'AWS_ACCESS_KEY_ID' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
    'AWS_SECRET_ACCESS_KEY' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
    'AWS_DEFAULT_REGION' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
    'AWS_BUCKET' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
];

$existing = DB::table('settings')->where('type', 'amazon_s3')->first();

if ($existing) {
    // Update if exists
    DB::table('settings')->where('type', 'amazon_s3')->update([
        'description' => json_encode($s3_config),
        'updated_at' => now(),
    ]);
} else {
    // Insert if not exists
    DB::table('settings')->insert([
        'type' => 'amazon_s3',
        'description' => json_encode($s3_config),
        'created_at' => now(),
        'updated_at' => now(),
    ]);
}
