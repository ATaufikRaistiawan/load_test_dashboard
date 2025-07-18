use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StatusApiController;

Route::get('/machine-status', [StatusApiController::class, 'status']);
