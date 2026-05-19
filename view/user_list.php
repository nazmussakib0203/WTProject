<html>
    <head>
        <title>Customer List</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css">
    </head>
    <body>
        <h1>Customer List</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Profile Picture</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Creation Time</th>
            </tr>
            <tbody>
                <?php include_once("../control/user_list_process.php"); ?>
            </tbody>
        </table>
    </body>

</html>