<?php

    require_once ('../HTMLParser.php');

    $data = array 
        (
            '{app.title}' => 'Custom PHP HTML Parser Editor', 
            '{html.sample}' => file_get_contents ('pages/demo.html'),
            '{php.sample}' => file_get_contents ('pages/demo.php.html'),
            '{ajax.run}' => ''
        );

    if (isset ($_POST['hcode']) && isset ($_POST['pcode']))
    {
        $htmlcode = base64_encode ($_POST['hcode']);
        $phpcode = base64_encode ($_POST['pcode']);

        $data['{html.sample}'] = base64_decode ($htmlcode);
        $data['{php.sample}'] = base64_decode ($phpcode);

        $data['{ajax.run}'] = "
            $('#loader').css('display', 'block');

            $.ajax({
            type: 'POST',
            url: 'run.php',
            data: JSON.stringify({
                htmlcode: '$htmlcode',
                phpcode: '$phpcode'
            }),
            success: function (data) {
                $('#output').attr('src', data.uri);
                $('#loader').css('display', 'none');
                $('#outputdiv').attr('style', 'overflow:hidden !important');
            },
            error: function (err) {

                if (err.hasOwnProperty('responseText')){
                    $('#error').css('display', 'block');
                    $('#error').text(err.responseText);
                }
                
                $('#loader').css('display', 'none');
                $('#output').css('display', 'none');
                console.log(err);
            },
            contentType: 'application/json',
            dataType: 'json'
        });";
    }

    $htmlparser = new App\Custom\HTMLParser (file_get_contents ('pages/index.html'), $data);
    $htmlstring = $htmlparser->GetSubstitutedString(); // get the parsed html string

    // check for errors
    if (App\Custom\Error::IsAnError ($htmlstring))
    {
        // handle error
        die ($htmlstring->GetError()); // gets error message
        // $htmlstring->GetCode(); // gets error code
    }

    echo $htmlstring;
?>