<?php

    require ('HTMLParser.php');

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
            'users' => array (
                    array ('{u.name}' => 'Yung Cet', '{u.role}' => 'Software Engineer'), 
                    array ('{u.name}' => 'Cedric Maenetja', '{u.role}' => 'Managing Director')
                ), 
            'products' => array (
                    array ('{products.name}' => 'Product 1', '{products.desc}' => 'description'), 
                    array ('{products.name}' => 'Product 2', '{products.desc}' => 'description'),
                    array ('{products.name}' => 'Product 3', '{products.desc}' => 'description'), 
                    array ('{products.name}' => 'Product 4', '{products.desc}' => 'description')
                ),
            '{products.total}' => 4, 
            '{clients.total}' => 7,
            '{app.title}' => 'Custom PHP HTML Parser',
            '{code1}' => '
<!-- checks if {clients.total} is > 0 from $data["{clients.total}"] in PHP code -->
<!--php-code
    return ({clients.total} > 0) ? "<h2>List of Clients {clients.total}</h2>" : "<h2>No Records!</h2>";
endcode-->

<!-- populates clients list from $data["clients"] in PHP code -->
<table>
    <tr>
        <th>Client</th>
        <th>Name</th>
        <th>Balance</th>
    </tr>
    <%=list dataset="clients"
        <tr class="class" id="1234">
            <td align="left">{client.id}</td>
            <td>{client.name}</td>
            <td>R{client.balance}</td>
        </tr>
    =%>
</table>',
        '{code2}' => '<table>
        <tr>
            <th>Client</th>
            <th>Name</th>
            <th>Balance</th>
        </tr>
        <%=list dataset="clients"
             <!--php-code
            return ({client.balance} > 0) 
                ? "<tr class="class" id="1234">
                    <td align="left">{client.id}</td>
                    <td>{client.name}</td>
                    <td>R{client.balance}</td>
                    </tr>" 
                : "";
            endcode-->
        =%>
    </table>',
    '{code3}' => '
<ul>
    <%=list dataset="products"
    <li>{products.name} {products.desc}</li>
    =%>
</ul>',
'{code4}' =>'
<%=dataset.map("users")
    <div class="card">
        <div class="container">
        <h4><b>{u.name}</b></h4> 
        <p>{u.role}</p> 
        </div>
    </div>
=%>',
'{code5}' =>'
<%=dataset.foreach("users")
    <div class="card">
        <div class="container">
        <h4><b>{u.name}</b></h4> 
        <p>{u.role}</p> 
        </div>
    </div>
=%>',
'{code6}' =>'
<%=dataset.for("users")
    <div class="card">
        <div class="container">
        <h4><b>{u.name}</b></h4> 
        <p>{u.role}</p> 
        </div>
    </div>
=%>',
        );
    
    $htmlparser = new App\Custom\HTMLParser (file_get_contents ('index.html'), $data);
    $htmlstring = $htmlparser->GetSubstitutedString();
    
    echo (App\Custom\Error::IsAnError ($htmlstring)) ? $htmlstring->GetError() : $htmlstring;

?>