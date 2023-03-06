<?php

if (! function_exists('settings')) {
    function settings($key = null, $default = null)
    {
        if ($key === null) {
            return app(App\Models\Setting::class)->all();
        }

        return app(App\Models\Setting::class)->get($key, $default);
    }
}

if (! function_exists('normalizeTelephoneNumber')) {
    function normalizeTelephoneNumber(string $telephone): string
    {
        $telephone = str_replace([' ', '.', '-', '(', ')'], '', $telephone);
        return $telephone;
    }
}

/* Фильтрация значения для sql оператора LIKE */
if (! function_exists('escapeLike')) {
    function escapeLike($value, $char = '\\')
    {
        return str_replace(
            [$char, '%', '_'],
            [$char . $char, $char . '%', $char . '_'],
            $value
        );
    }
}

/* Конвертация изображений в webp формат */
if (! function_exists('webpImage')) {
    function webpImage($source, $quality = 100, $removeOld = false)
    {
        if (!$source) {
            return null;
        }

        if ($source[0] === '/') {
            $source = $_SERVER["DOCUMENT_ROOT"].$source;
        } else {
            $source = $_SERVER["DOCUMENT_ROOT"].'/'.$source;
        }

        $dir = pathinfo($source, PATHINFO_DIRNAME);
        $name = pathinfo($source, PATHINFO_FILENAME);
        $destination = $dir . '/' . $name . '.webp';
        $info = getimagesize($source);
        $isAlpha = false;

        if ($info) {
            if ($info['mime'] == 'image/jpeg') {
                $image = imagecreatefromjpeg($source);
            } elseif ($isAlpha = $info['mime'] == 'image/gif') {
                $image = imagecreatefromgif($source);
            } elseif ($isAlpha = $info['mime'] == 'image/png') {
                $image = imagecreatefrompng($source);
            } else {
                return $source;
            }
        } else {
            return;
        }

        if ($isAlpha) {
            imagepalettetotruecolor($image);
            imagealphablending($image, true);
            imagesavealpha($image, true);
        }

        imagewebp($image, $destination, $quality);

        if ($removeOld)
            unlink($source);

        return $destination;
    }
}

/* Получить путь до webp изображения */
if (! function_exists('getWebpImagePath')) {
    function getWebpImagePath($source)
    {
        return pathinfo($source, PATHINFO_DIRNAME).'/'.pathinfo($source, PATHINFO_FILENAME).'.webp';
    }
}
