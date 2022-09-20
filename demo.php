<?php

    require ('HTMLParser/HTMLParser.php');

    $data = array 
        (
            'clients' => array (
                    array ('{client.name}' => 'Yung Cet 1', '{client.id}' => '12341', '{client.balance}' => '10'),
                    array ('{client.name}' => 'Yung Cet 2', '{client.id}' => '12342', '{client.balance}' => '55'),
                    array ('{client.name}' => 'Yung Cet 3', '{client.id}' => '12343', '{client.balance}' => '-100'),
                    array ('{client.name}' => 'Yung Cet 4', '{client.id}' => '12344', '{client.balance}' => '0'),
                    array ('{client.name}' => 'Yung Cet 5', '{client.id}' => '12345', '{client.balance}' => '-60'),
                    array ('{client.name}' => 'Yung Cet 6', '{client.id}' => '12346', '{client.balance}' => '30'),
                    array ('{client.name}' => 'Yung Cet 7', '{client.id}' => '12347', '{client.balance}' => '30')
                ),
            'clients_test' => array (
                    array ('{client.name}' => 'Yung Cet 1', '{client.id}' => '12341', '{client.balance}' => '10'),
                    array ('{client.name}' => 'Yung Cet 2', '{client.id}' => '12342', '{client.balance}' => '55'),
                    array ('{client.name}' => 'Yung Cet 3', '{client.id}' => '12343', '{client.balance}' => '-100'),
                    array ('{client.name}' => 'Yung Cet 4', '{client.id}' => '12344', '{client.balance}' => '0'),
                    array ('{client.name}' => 'Yung Cet 5', '{client.id}' => '12345', '{client.balance}' => '-60'),
                    array ('{client.name}' => 'Yung Cet 6', '{client.id}' => '12346', '{client.balance}' => '30'),
                    array ('{client.name}' => 'Yung Cet 7', '{client.id}' => '12347', '{client.balance}' => '30')
                ),
            'users' => array (
                    array ('{users.name}' => 'Yung', '{users.desc}' => 'Cet'), 
                    array ('{users.name}' => 'Cedric', '{users.desc}' => 'Maenetja')
                ), 
            'products' => array (
                    array ('{products.name}' => 'Product 1', '{products.desc}' => 'description'), 
                    array ('{products.name}' => 'Product 2', '{products.desc}' => 'description'),
                    array ('{products.name}' => 'Product 3', '{products.desc}' => 'description'), 
                    array ('{products.name}' => 'Product 4', '{products.desc}' => 'description')
                ),
            array ('{products.total}' => 4, '{clients.total}' => 7),
        );
    
    $htmlparser = new App\Custom\HTMLParser (file_get_contents ('index.html'), $data);
    $htmlstring = $htmlparser->GetSubstitutedString();
    
    echo (App\Custom\Error::IsAnError ($htmlstring)) ? $htmlstring->GetError() : $htmlstring;

?>