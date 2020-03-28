<?php

namespace App\Exceptions;

use Exception;

class ValidationErrorException extends Exception
{
    /**
     * Render the exception as an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        //Validasi error akan mengarah ke respon berikut karena otomatis diarahkan dari Exceptions/Hanlder.php@render
        return response()->json([
            'errors' =>  [
                'code' => 422,
                'title' => 'Validation error',
                'detail' => 'Your request is malformed of missing fields.',
                'meta' => json_decode($this->getMessage()),
            ]
        ], 422);
    }
}
