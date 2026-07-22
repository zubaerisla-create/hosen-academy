use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

if (!Schema::hasColumn('users', 'google_id')) {
Schema::table('users', function (Blueprint $table) {
$table->string('google_id', 255)->nullable();
});
}
