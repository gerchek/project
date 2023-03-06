<?php

namespace App\Http\Controllers;

use App\Models\DocumentsItem;

class DocumentsController extends Controller
{
    public function index()
    {
        $groupedDocs = DocumentsItem::getGroupedDocuments();

        return view('documents', compact('groupedDocs'));
    }
}