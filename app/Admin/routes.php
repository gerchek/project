<?php

Route::get('', ['as' => 'admin.dashboard', function () {
    $content = 'Добро пожаловать в админ-панель сайта Краевого центра единоборств.';
    return AdminSection::view($content, 'Админ-панель КЦЕ');
}]);
/**
 * Логи сервера
 */
Route::get('logs', ['as' => 'admin.logs', function () {
    if (auth()->user()->isAdmin()) {
        $content = new \Rap2hpoutre\LaravelLogViewer\LogViewerController;
        $content = $content->index();
        return $content;
    } else {
        return AdminSection::view('Данный раздел могут просматривать только администраторы сайта.', 'Доступ запрещен');
    }
}]);

/**
 * Главные настройки сайта
 */
Route::get('/settings', '\App\Models\Setting@getSettings')->name('admin.settings.get');
Route::post('/settings', '\App\Models\Setting@updateSettings')->name('admin.settings.post');

/**
 * Очистка кэша
 */
Route::get('/clear_cache', ['as' => 'admin.cache.list', 'uses' => '\App\Http\Controllers\Admin\CacheController@getList']);
Route::post('/clear_cache', ['as' => 'admin.cache.clear', 'uses' => '\App\Http\Controllers\Admin\CacheController@clearCache']);

/**
 * Редиректы
 */
Route::redirect('/contacts', '/admin/contacts/1/edit');
Route::redirect('/main_pages', '/admin/main_pages/1/edit');

Route::get('show_feedback_form/{id}', function ($id)
{
    $element = \App\Models\FormFeedback::findOrFail($id);
    return new \App\Mail\FeedbackFormFilled($element);
});



Route::post('file_upload', function()
{
    ini_set('error_reporting', 0);
    ini_set('display_errors', 0);
    $upload_handler = new \App\Admin\Handlers\FileUploadHandler();
});

Route::post('wysiwig_image_upload', function()
{
    $file = request()->file('file');
    $uploadDirectory = config('sleeping_owl.imagesUploadDirectory');
    $uploadFilenameBehavior = config('sleeping_owl.imagesUploadFilenameBehavior');

    $isFileExists = file_exists(public_path($uploadDirectory).DIRECTORY_SEPARATOR.$file->getClientOriginalName());
    $uploadFileName = $file->getClientOriginalName();

    $filenameWithoutExtensions = substr($file->getClientOriginalName(), 0, strrpos($file->getClientOriginalName(), '.'));

    //Код ниже частично взят из vendor/laravelrus/sleepingowl/src/Http/Controllers/UploadController.php
    switch ($uploadFilenameBehavior) {
        case 'UPLOAD_ORIGINAL_ALERT':
            if ($isFileExists) {
                $result['uploaded'] = 0;
                $result['error']['message'] = 'Файл с таким именем уже существует. Измените имя файла и попробуйте еще раз';
                $uploadFileName = false;
            }
            break;
        case 'UPLOAD_ORIGINAL_ADD_HASH':
            if ($isFileExists) {
                $uploadFileName = $filenameWithoutExtensions
                    .'_'.md5(time().$filenameWithoutExtensions)
                    .'.'.$file->getClientOriginalExtension();
                $result['error']['message'] = "Файл с таким именем уже существовал. Загружаемый файл был переименован в '{$uploadFileName}'";
            }
            break;
        case 'UPLOAD_ORIGINAL_ADD_INCREMENT':
            if ($isFileExists) {
                $index = 1;
                $uploadFileName = $filenameWithoutExtensions.'_'.$index.'.'.$file->getClientOriginalExtension();
                while (
                    file_exists(public_path($uploadDirectory).DIRECTORY_SEPARATOR.$uploadFileName)
                    and
                    $index < $this->uploadFilenameIncrementMax
                ) {
                    $index++;
                    $uploadFileName = $filenameWithoutExtensions.'_'.$index.'.'.$file->getClientOriginalExtension();
                }
                $result['error']['message'] = "Файл с таким именем уже существовал. Загружаемый файл был переименован в '{$uploadFileName}'";
                if ($index == $this->uploadFilenameIncrementMax) {
                    $uploadFileName = false;
                    $result['uploaded'] = 0;
                    $result['error']['message'] = 'Файл с таким именем уже существовал. Имя подобрать не удалось. Переименуйте файл и попробуйте еще раз';
                }
            }
            break;
        case 'UPLOAD_ORIGINAL_REWRITE':
            if ($isFileExists) {
                $result['error']['message'] = 'Файл с таким именем уже существовал и был перезаписан';
            }
            break;
        default:
            //UPLOAD_HASH
            $uploadFileName = md5(time().$filenameWithoutExtensions).'.'.$file->getClientOriginalExtension();
            $result['error']['message'] = "Файл был переименован в '{$uploadFileName}'";
            break;
    }

    if ($uploadFileName) {
        $file->move(public_path($uploadDirectory), $uploadFileName);
        $result['location'] = '/'.$uploadDirectory.'/'.$uploadFileName;
    }

    // Конвертация изображений, загружаемых через редактор, в WEBP на лету
    if (!webpImage($result['location'])) {
        \MessagesStack::addError('WEBP изображение не было создано');
    }

    return $result;
});

Route::post('{model}/image/{field?}/{id?}', function()
{
    $file = request()->file('file');
    $uploadDirectory = config('sleeping_owl.imagesUploadDirectory');
    $uploadFilenameBehavior = config('sleeping_owl.imagesUploadFilenameBehavior');

    $isFileExists = file_exists(public_path($uploadDirectory).DIRECTORY_SEPARATOR.$file->getClientOriginalName());
    $uploadFileName = $file->getClientOriginalName();

    $filenameWithoutExtensions = substr($file->getClientOriginalName(), 0, strrpos($file->getClientOriginalName(), '.'));

    //Код ниже частично взят из vendor/laravelrus/sleepingowl/src/Http/Controllers/UploadController.php
    switch ($uploadFilenameBehavior) {
        case 'UPLOAD_ORIGINAL_ALERT':
            if ($isFileExists) {
                $result['uploaded'] = 0;
                $result['error']['message'] = 'Файл с таким именем уже существует. Измените имя файла и попробуйте еще раз';
                $uploadFileName = false;
            }
            break;
        case 'UPLOAD_ORIGINAL_ADD_HASH':
            if ($isFileExists) {
                $uploadFileName = $filenameWithoutExtensions
                    .'_'.md5(time().$filenameWithoutExtensions)
                    .'.'.$file->getClientOriginalExtension();
                $result['error']['message'] = "Файл с таким именем уже существовал. Загружаемый файл был переименован в '{$uploadFileName}'";
            }
            break;
        case 'UPLOAD_ORIGINAL_ADD_INCREMENT':
            if ($isFileExists) {
                $index = 1;
                $uploadFileName = $filenameWithoutExtensions.'_'.$index.'.'.$file->getClientOriginalExtension();
                while (
                    file_exists(public_path($uploadDirectory).DIRECTORY_SEPARATOR.$uploadFileName)
                    and
                    $index < $this->uploadFilenameIncrementMax
                ) {
                    $index++;
                    $uploadFileName = $filenameWithoutExtensions.'_'.$index.'.'.$file->getClientOriginalExtension();
                }
                $result['error']['message'] = "Файл с таким именем уже существовал. Загружаемый файл был переименован в '{$uploadFileName}'";
                if ($index == $this->uploadFilenameIncrementMax) {
                    $uploadFileName = false;
                    $result['uploaded'] = 0;
                    $result['error']['message'] = 'Файл с таким именем уже существовал. Имя подобрать не удалось. Переименуйте файл и попробуйте еще раз';
                }
            }
            break;
        case 'UPLOAD_ORIGINAL_REWRITE':
            if ($isFileExists) {
                $result['error']['message'] = 'Файл с таким именем уже существовал и был перезаписан';
            }
            break;
        default:
            //UPLOAD_HASH
            $uploadFileName = md5(time().$filenameWithoutExtensions).'.'.$file->getClientOriginalExtension();
            $result['error']['message'] = "Файл был переименован в '{$uploadFileName}'";
            break;
    }

    if ($uploadFileName) {
        $file->move(public_path($uploadDirectory), $uploadFileName);

        $result['path'] = asset($uploadDirectory.'/'.$uploadFileName);
        $result['value'] = $uploadDirectory.'/'.$uploadFileName;
    }

    // Конвертация изображений, загружаемых через поля админки, в WEBP на лету
    if (!webpImage($result['value'])) {
        \MessagesStack::addError('WEBP изображение не было создано');
    }

    return $result;
});

/**
 * Массовое удаление записей обратной связи
 */
Route::get('/form_feedbacks/all_delete', '\App\Http\Controllers\Admin\FormFeedbacksController@allDelete');
Route::get('/form_feedbacks/{ids}/selected_delete', '\App\Http\Controllers\Admin\FormFeedbacksController@selectedDelete');
