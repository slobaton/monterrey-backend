<?php

use Illuminate\Http\Exceptions\HttpResponseException;

if (! function_exists('abort_json')) {
    /**
     * Abort the current request and return a JSON response with the given status.
     *
     * @param int $status
     * @param string|null $message
     * @param array $data
     * @param array $headers
     *
     * @throws HttpResponseException
     */
    function abort_json(int $status, ?string $message = null, array $data = [], array $headers = [])
    {
        $defaultText = $message ?? (\Symfony\Component\HttpFoundation\Response::$statusTexts[$status] ?? 'Error');
        $payload = array_merge(['message' => $defaultText], $data);

        throw new HttpResponseException(response()->json($payload, $status, $headers));
    }
}
