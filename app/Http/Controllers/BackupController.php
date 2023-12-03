<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
class BackupController extends Controller
{
    // public function generarBackup()
    // {
    //     $rutaBat = 'C:\\xampp\\htdocs\\HDB-Epi\\public\\backup\\prueba.bat';
    //     exec($rutaBat);
    //     sleep(3);
    //     $archivos = glob(storage_path("app/public/backups/backup_HDB-Epidemiologia_*.backup"));
    //     $ultimoArchivo = end($archivos);
    //     if ($ultimoArchivo) {
    //         $response = Response::make(file_get_contents($ultimoArchivo));
    //         $response->header('Content-Type', 'application/octet-stream');
    //         $response->header('Content-Disposition', "attachment; filename=\"" . basename($ultimoArchivo) . "\"");
    //         return $response;
    //     } else {
    //         return response()->json(['error' => 'No se encontraron archivos de respaldo.']);
    //     }
    // }
    public function generarBackup()
    {
        $rutaBat = 'C:\\xampp\\htdocs\\HDB-Epi\\public\\backup\\prueba.bat';

        exec($rutaBat);

        sleep(2);

        $archivos = glob(storage_path("app/public/backups/backup_HDB-Epidemiologia_*.backup"));
        $ultimoArchivo = end($archivos);

        if ($ultimoArchivo) {

            $zip = new \ZipArchive();
            $archivoZip = storage_path("app/public/backups/backup_HDB-Epidemiologia.zip");

            if ($zip->open($archivoZip, \ZipArchive::CREATE) === true) {

                $zip->addFile($ultimoArchivo, basename($ultimoArchivo));
                $zip->close();

                $response = Response::make(file_get_contents($archivoZip));
                $response->header('Content-Type', 'application/zip');
                $response->header('Content-Disposition', "attachment; filename=\"" . basename($archivoZip) . "\"");

                register_shutdown_function('unlink', $archivoZip);

                return $response;
            } else {
                return response()->json(['error' => 'No se pudo crear el archivo ZIP.']);
            }
        } else {
            return response()->json(['error' => 'No se encontraron archivos de respaldo.']);
        }
    }

    protected function schedule(Schedule $schedule)
    {

        $schedule->call(function () {
            $carpetaBackups = storage_path('app/public/backups');


            $archivos = glob("{$carpetaBackups}/*");


            $tiempoLimite = now()->subDay();


            foreach ($archivos as $archivo) {
                if (filemtime($archivo) < $tiempoLimite->timestamp) {
                    unlink($archivo);
                }
            }
        })->daily();
    }


}
