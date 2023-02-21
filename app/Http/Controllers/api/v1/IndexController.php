<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function __invoke()
    {
        return response()->json(['hello' => 'MacPaw Internship 2022!']);
    }
}
