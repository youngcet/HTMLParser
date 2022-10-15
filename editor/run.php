<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers");
    header("Cache-Control: must-revalidate");
    $offset = 60 * 60 * 24 * 3;
    $ExpStr = "Expires: ". gmdate("D, d M Y H:i:s", time() + $offset) . "GMT";
    header($ExpStr);

    require ('Constants.php');
    require ('../HTMLParser.php');

    $results = '';
    $requiredfields = array ('htmlcode', 'phpcode');

    $postData = json_decode (file_get_contents ("php://input"), true);
    if (empty ($postData))
    {
        http_response_code (App\Constants::BAD_REQUEST);
        exit (json_encode (array ("error" => App\Constants::MISSING_PARAMETERS, 'code' => App\Constants::BAD_REQUEST)));
    }
    
    foreach ($requiredfields as $key)
    {
        if (! array_key_exists ($key, $postData) || empty ($postData[$key]))
		{
		    http_response_code (App\Constants::BAD_REQUEST);
            exit (json_encode (array ("error" => App\Constants::MISSING_PARAMETERS, 'code' => App\Constants::BAD_REQUEST)));
		}
    }

    $phpcode = base64_decode ($postData['phpcode']);

    $htmlfile = "run/output.html";
    file_put_contents ($htmlfile, base64_decode ($postData['htmlcode']));

    $htmlparser = new App\Custom\HTMLParser ($phpcode, array ('?>' => '', '<?php' => '', '__INDEX__' =>  $htmlfile));
    $phpcode = $htmlparser->GetSubstitutedString();
    if (App\Custom\Error::IsAnError ($phpcode))
    {
        http_response_code (App\Constants::BAD_REQUEST);
        exit (json_encode (array ("error" => $phpcode->GetError(), 'code' => $phpcode->GetCode())));
    }

    try
    {
        $results = eval ("$phpcode");
    }
    catch (ParseError $e)
    {
        http_response_code (App\Constants::BAD_REQUEST);
        exit (json_encode (array ("error" => '[PHP Compile Error] '.$e->getMessage(), 'code' => App\Constants::BAD_REQUEST)));
    }

    if (! $results) 
    {
        $results = $phpcode;
        $htmlfile = '';
    }
    else
    {
        file_put_contents ($htmlfile, $results);
        
        http_response_code (App\Constants::REQUEST_OK);
        exit (json_encode (array ('results' => App\Constants::SUCCESS, 'uri' => $htmlfile)));
    }
?>