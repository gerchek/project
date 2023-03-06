<?php

namespace App\Models\Traits;

trait Macros
{
    private function macros($attr)
    {
        $text = trim($this->attributes[$attr]);

        $text = str_replace('<h1>', '<h1 class="event__title">', $text);
        $text = str_replace('<h2>', '<h2 class="event__subtitle">', $text);
        $text = str_replace('<p>', '<p class="event__text">', $text);
        $text = str_replace('<a rel="noopener"', '<a rel="noopener" class="event__link"', $text);
        $text = str_replace('<a href', '<a class="event__link" href', $text);
        $text = str_replace('<img src', '<img class="event__img" src', $text);
        $text = str_replace('<ul', '<ul class="event__list"', $text);
        $text = str_replace('<li', '<li class="event__item"', $text);

        // Удаляем все блоки с классом .event__doc_edge-block
        // $text = preg_replace('~<span.*class=".*event__doc_edge-block.*">.*</span>~Ui', '', $text);

        return $text;
    }
}