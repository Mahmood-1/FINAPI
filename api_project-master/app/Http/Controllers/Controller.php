<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function success($message, $status_code=200) {
    	return response()->json(['status' => 'success', 'message' => $message, 'errors' => 0], $status_code);
    }

    public function error($message, $status_code=500) {
    	return response()->json(['status' => 'error', 'message' => $message, 'errors' => 1], $status_code);
    }

    public function image_upload($image, $dir) {
		$name = time() . '.' . $image->getClientOriginalName();
		$image->move(public_path('images' . DIRECTORY_SEPARATOR . $dir), $name);
		return $dir . DIRECTORY_SEPARATOR . $name;
    }
}
