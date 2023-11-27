<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class BackupController extends Controller
{
    // public function generarBackup()
    // {
    //     // Comando para generar el backup
    //     $comando = 'pg_dump -U postgres -W -h localhost HDB-Epidemiologia > prueba.sql';

    //     // Ejecutar el comando
    //     exec($comando);

    //     // Guardar el archivo en el sistema de archivos de Laravel
    //     $rutaBackup = storage_path('app/prueba.sql');
    //     file_put_contents($rutaBackup, file_get_contents('prueba.sql'));

    //     // Descargar el archivo
    //     return response()->download($rutaBackup)->deleteFileAfterSend();
    // }
    // public function generarBackup()
    // {
    //     // Contraseña de PostgreSQL
    //     $contrasenaPostgres = 'sistemas';

    //     // Comando para generar el backup
    //     $comando = sprintf(
    //         'PGPASSWORD=%s pg_dump -U postgres -h localhost HDB-Epidemiologia > prueba123.sql',
    //         escapeshellarg($contrasenaPostgres)
    //     );

    //     // Ejecutar el comando
    //     exec($comando);

    //     // Guardar el archivo en el sistema de archivos de Laravel
    //     $rutaBackup = storage_path('app/prueba123.sql');
    //     file_put_contents($rutaBackup, file_get_contents('prueba123.sql'));

    //     // Descargar el archivo
    //     return response()->download($rutaBackup)->deleteFileAfterSend();
    // }
    // public function generarBackup()
    // {
    //     // Ruta al archivo .bat
    //     $rutaBat = 'C:\\Users\\asdhg\\OneDrive\\Escritorio\\prueba.bat';

    //     // Ejecutar el archivo .bat
    //     exec($rutaBat);

    //     // Nombre del archivo de respaldo
    //     // $nombreArchivo = 'backup_' . date('Ymd_His') . '.backup';

    //     // Ruta al archivo de respaldo
    //     $rutaBackup = 'C:\\Users\\asdhg\\OneDrive\\Escritorio\\backups\\';

    //     // Descargar el archivo
    //     return response()->download($rutaBackup)->deleteFileAfterSend();
    // }
    public function generarBackup()
    {
        // Ruta al archivo .bat
        $rutaBat = 'C:\\Users\\asdhg\\OneDrive\\Escritorio\\prueba.bat';

        // Ejecutar el archivo .bat
        exec($rutaBat);
        return back();
    }

}
