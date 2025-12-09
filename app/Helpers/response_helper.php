<?php

if (!function_exists('json_response')) {
    /**
     * Helper function to return a JSON response.
     *
     * @param array|object $data The data to be returned.
     * @param int $status_code The HTTP status code.
     * @param string $message A custom status message.
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    function json_response($data = [], int $status_code = 200, string $message = 'OK')
    {
        $response = service('response'); // Get the global response instance
        
        $response->setStatusCode($status_code, $message);
        $response->setHeader('Content-Type', 'application/json');
        
        // Format the data into a standard structure
        $output = [
            'status'  => $status_code,
            'message' => $message,
            'data'    => $data,
        ];

        $response->setBody(json_encode($output));

        return $response;
    }
}

if (!function_exists('error_response')) {
    /**
     * Helper function for error responses.
     *
     * @param string $message The error message.
     * @param int $status_code The HTTP status code (e.g., 400, 404, 500).
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    function error_response(string $message, int $status_code = 400)
    {
        return json_response([], $status_code, $message);
    }
}