# HTMLParser

Parsers HTML string with PHP Code

# Usage
```
require ('HTMLParser/HTMLParser.php');

$htmlparser = new App\Custom\HTMLParser ($htmlstring, $data);
$htmlstring = $htmlparser->GetSubstitutedString(); // get the parsed html string

// check for errors
if (App\Custom\Error::IsAnError ($htmlstring))
{
    // handle error
    // $htmlstring->GetError(); // gets error message
    // $htmlstring->GetCode(); // gets error code
}
```

# Parameters Explanined
$htmlstring the actual html string
```
<!DOCTYPE html>
<html>

<head>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>

<body>

    <!--php-code
        return ('{clients.total}' > 0) ? '<h2>List of Clients {clients.total}</h2>' : '<h2>No Records!</h2>';
    endcode-->


    <table>
        <tr>
            <th>Client</th>
            <th>Name</th>
            <th>Balance</th>
        </tr>
        <%=list dataset="clients_test"
            <tr class="class" id="1234">
                <td align="left">{client.id}</td>
                <td>{client.name}</td>
                <td>R{client.balance}</td>
            </tr>
        =%>
    </table>
    <h2>List of Clients with Balances > 0</h2>
    <table>
        <tr>
            <th>Client</th>
            <th>Name</th>
            <th>Balance</th>
        </tr>
        <%=list dataset="clients"
             <!--php-code
            return ({client.balance} > 0) 
                ? '<tr class="class" id="1234">
                    <td align="left">{client.id}</td>
                    <td>{client.name}</td>
                    <td>R{client.balance}</td>
                    </tr>' 
                : '';
            endcode-->
        =%>
    </table>
    <h2>List {users.list_title}</h2>
    <ol>
        <%=list dataset="users"
        <li class="class class">{users.name} {users.desc}</li>
        =%>
    </ol>
    <h2>List {products.list_title}</h2>
    <ul>
        <%=list dataset="products"
        <li>{products.name} {products.desc}</li>
        =%>
    </ul>
</body>

</html>
```

$data is an array of data to substitute on the html string. All keys that need to be substituted must be enclosed in curly brackets {}. See below:

```
$data => array (
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
```

# Populating a list
A list can be populated as below:
```
<ul>
        <%=list dataset="products"
        <li>{products.name} {products.desc}</li>
        =%>
    </ul>
 ```
 
dataset="products" specifies the array key from the $data. Any values enclosed in curly brackets are values to substitute from the given array (products in this case). If there are no values enclosed in curly brackets, whichever text will be populated on the list. This applies to anything besides HTML lists, for example, this can also be used to populate an HTML table rows:
```
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
    </table>
```

# Adding PHP Code
PHP code can be added as below (All values in curcly brackets will be substituted from the given $data):

```
<!--php-code
        return ('{clients.total}' > 0) ? '<h2>List of Clients {clients.total}</h2>' : '<h2>No Records!</h2>';
    endcode-->
```

Additionally, you can also add PHP code inside a <%=list dataset="yourarray" =%> to add logic.
```
<table>
        <tr>
            <th>Client</th>
            <th>Name</th>
            <th>Balance</th>
        </tr>
        <%=list dataset="clients"
             <!--php-code
            return ({client.balance} > 0) 
                ? '<tr class="class">
                    <td align="left">{client.id}</td>
                    <td>{client.name}</td>
                    <td>R{client.balance}</td>
                    </tr>' 
                : '';
            endcode-->
        =%>
    </table>
 ```
