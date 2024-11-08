<?php
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PdfController;
use App\Models\Bien;
use App\Models\Movimiento;
use App\Models\Personal;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/generate-pdf/{id}', [PdfController::class, 'generatePDF'])->name('generaPDF');

    Route::get('/inventario', function () {
        return view('inventario.bienes');
    })->name('bienes');

    Route::get('/inventario/bajas', function () {
        return view('inventario.bienes.bajasLista');
    })->name('bajas');

    Route::get('/inventario/{id}', function ($id) {
        $bienes = Bien::findOrFail($id);
        return view('inventario.bienes-detalle', compact('bienes'));
    })->name('bienes.detalle');



    Route::get('/personal', function () {
        return view('inventario.personal');
    })->name('personal');

    Route::get('/personal/{id}', function ($id) {
        $personal = Personal::findOrFail($id);
        return view('inventario.personal-detalle', compact('personal'));
    })->name('personal.detalle');


    Route::get('/movimientos', function () {
        return view('inventario.movimientos');
    })->name('movimientos');


    Route::get('/movimientos/resguardos', function () {
        return view('inventario.resguardos');
    })->name('resguardos');

    Route::get('/movimientos/alta_bienes', function () {
        return view('inventario.movimintos.bienesMovimientos');
    })->name('Alta_Bienes');

    Route::get('/movimientos/devolucion_bienes', function () {
        return view('inventario.movimintos.DevolucionMovimientos');
    })->name('devolucion_bienes');

    Route::get('/movimientos/folios/{id}', function ($id) {
        $folio = Movimiento::findOrFail($id);
        return view('inventario.folios.detallesFolios', compact('folio'));
    })->name('detallesFolios');
});
