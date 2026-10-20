<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class SquareImage
{
    const SIZE = 1080;          // output edge in px
    const MAX_BYTES = 1048576;  // 1 MB

    /** Center-crop to 1:1, resize, compress to <= 1 MB, store as JPEG on the public disk. Returns the stored path. */
    public static function store(UploadedFile $file, string $dir): string
    {
        $path = $file->getRealPath();
        // decode by content, not extension: files are often renamed (e.g. WebP saved as .png)
        $src = @imagecreatefromstring(file_get_contents($path));
        if (! $src) {
            throw ValidationException::withMessages(['image' => 'Format gambar tidak didukung. Gunakan JPG, PNG, atau WebP.']);
        }

        // phones store portrait shots rotated via EXIF; apply it before cropping
        $orientation = function_exists('exif_read_data') ? (@exif_read_data($path)['Orientation'] ?? 1) : 1;
        $angle = [3 => 180, 6 => -90, 8 => 90][$orientation] ?? 0;
        if ($angle) {
            $src = imagerotate($src, $angle, 0);
        }

        $w = imagesx($src);
        $h = imagesy($src);
        $side = min($w, $h);
        $out = min($side, self::SIZE);

        $dst = imagecreatetruecolor($out, $out);
        imagefill($dst, 0, 0, imagecolorallocate($dst, 255, 255, 255)); // flatten PNG transparency onto white
        imagecopyresampled($dst, $src, 0, 0, intdiv($w - $side, 2), intdiv($h - $side, 2), $out, $out, $side, $side);

        // lower quality until it fits; JPEG q40 at 1080px is far below 1 MB so this always ends
        for ($q = 85; $q >= 40; $q -= 10) {
            ob_start();
            imagejpeg($dst, null, $q);
            $bin = ob_get_clean();
            if (strlen($bin) <= self::MAX_BYTES) {
                break;
            }
        }

        $name = $dir.'/'.bin2hex(random_bytes(10)).'.jpg';
        Storage::disk('public')->put($name, $bin);

        return $name;
    }
}
