<?php

    namespace App;

    class Constants
    {
        const SUCCESS = 'success';

        // status codes
        const REQUEST_OK = '200';
        const BAD_REQUEST = '400';
        const UNAUTHORIZED_REQUEST = '401';
        const FORBIDDEN_REQUEST = '403';
        const NOT_FOUND_REQUEST = '404';
        const METHOD_NOT_ALLOWED = '405';
        const NOT_ACCEPTABLE = '406';
        const INTERNAL_SERVER_ERROR = '500';

        const HTTP_METHOD_INVALID = 'HTTP request method not allowed';
        const HTTP_CONTENT_TYPE_INVALID = 'Invalid Content Type';
        const MISSING_PARAMETERS = 'Missing required parameters';
        const FORBIDDEN_REQUEST_ERROR = 'Forbidden Request - 403';
        const NOT_ACCEPTABLE_HEADERS = 'Missing required headers';
    }

?>