<?php

namespace App\View\Composers;

use App\Models\Contact;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

class ContactsComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $contacts = Cache::rememberForever('contacts', function () {
            return Contact::first();
        });

        $view->with(compact('contacts'));
    }
}