# HTMLParser

This package can process HTML to replace it with parameter values.

It can take a string with HTML tags and processes it by finding marks with a specific format that identifies the places in the string that it will replace with values taken from an array of parameters.

The package can also support unique tags that identify literal PHP code that will not be changed while processing the HTML tags.

The package returns the HTML string after replacing the unique tags as the result of the processing task.

## Demo
https://permanentlink.co.za/HTMLParser/editor/index

## Documentation
https://permanentlink.co.za/HTMLParser/documentation/


# Usage
```
require ('HTMLParser/HTMLParser.php');

$htmlparser = new App\Custom\HTMLParser (file_get_contents ('index.html'), $data);
$htmlstring = $htmlparser->GetSubstitutedString(); // get the parsed html string

// check for errors
if (App\Custom\Error::IsAnError ($htmlstring))
{
    // handle error
    // $htmlstring->GetError(); // gets error message
    // $htmlstring->GetCode(); // gets error code
}

echo $htmlstring;

```

# Parameters Explained
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
### Populating a list using list dataset
```
<ul>
    <%=list dataset="products"
    <li>{products.name} {products.desc}</li>
    =%>
</ul>
 ```

### Populating a list using dataset.map()
 ```
<ul>
    <%=dataset.map("products")
    <li>{products.name} {products.desc}</li>
    =%>
</ul>
 ```

### Populating a list using foreach()
 ```
<ul>
    <%=foreach("products")
    <li>{products.name} {products.desc}</li>
    =%>
</ul>
 ```

### Populating a list using for()
 ```
<ul>
    <%=for("products")
    <li>{products.name} {products.desc}</li>
    =%>
</ul>
 ```
 
"products" specifies the array key from the $data. Any values enclosed in curly brackets are values to substitute from the given array (products in this case). If there are no values enclosed in curly brackets, whichever text will be populated on the list. This applies to anything besides HTML lists, for example, this can also be used to populate an HTML table rows or **divs**:
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

<%=list dataset="clients"
    <div class="cards">
        <p>{client.id}: {client.name}: {client.balance}</p>
    </div>
=%>
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
 
 # Using Custom PHP HTML Parser Editor
 There is an editor included in this repo, to run it:
 - Start your PHP server (via command line php -S localhost:8080)
 - Navigate to http://localhost:8080/editor/ or http://localhost/HTMLParser/editor/ or http://PATH_TO_HTMLPARSER/editor/
 - Your editor is now ready. You can edit and compile your code.
 - Demo: https://permanentlink.co.za/HTMLParser/editor/index
 
 **Note:** You can only compile the code in the editor on a local PHP server.
 
 Full documentation on the wiki: https://github.com/youngcet/HTMLParser/wiki
