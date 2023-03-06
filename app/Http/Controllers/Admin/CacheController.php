<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use \SleepingOwl\Admin\Http\Controllers\AdminController;

class CacheController extends AdminController
{
    public function getList()
    {
        return $this->renderContent(view('admin.cache.form'));
    }

    public function clearCache(Request $request)
    {
        if (!empty($request->cache))
            \Artisan::call('cache:clear');
        if (!empty($request->config))
            \Artisan::call('config:clear');
        if (!empty($request->view))
            \Artisan::call('view:clear');
        if (!empty($request->route))
            \Artisan::call('route:clear');

        \MessagesStack::addSuccess('Кэш очищен!');
        return $this->renderContent(view('admin.cache.form'));
    }
}