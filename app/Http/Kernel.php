use App\Http\Middleware\CheckRole;

class Kernel extends HttpKernel
{
    /**
     * The application's route middleware aliases.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $middlewareAliases = [
        'role' => \App\Http\Middleware\CheckRole::class,
    ];
}