use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

if (!Schema::hasColumn('seo_fields', 'bundle_id')) {
Schema::table('seo_fields', function(Blueprint $table) {
    $table->integer('bundle_id')->nullable();
});
}
