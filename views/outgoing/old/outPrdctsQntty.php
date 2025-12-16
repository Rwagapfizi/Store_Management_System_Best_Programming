<?php

$products = array();

include "../connect.php";

if (!$connection) {
    echo "Connection failed..." . mysqli_connect_error();
} else {
    $query = "SELECT  prod.productId, prod.product_Name, sum(outg.quantity) AS quantity from stk_outgoing outg INNER JOIN stk_products prod ON outg.productId=prod.productId GROUP BY outg.productId";
    $result = mysqli_query($connection, $query);
    echo "<style>table {margin: 2% auto;width: 98%;border-collapse: collapse;}
    th,td {border: 1px solid #808080;padding: 1%;text-align: center;text-wrap: wrap;}</style>";

    while ($row = mysqli_fetch_assoc($result)) {
        array_push($products, $row);
    }
    if (count($products) < 1){
        echo "<caption>There no products in the outgoing.</caption>";
    } 
    else{
        echo "<table><tr><th>Product Id</th><th>Product Name</th><th>Total quantity</th>";
        for($x=0;$x<count($products);$x++){
            echo "<tr>
    <td>" . $products[$x]['productId'] . "</td>
    <td>" . $products[$x]['product_Name'] . "</td>
    <td>" . $products[$x]['quantity'] . "</td>
    </tr>
    ";
        }
    }
    echo "</table>";
    echo "<br><a href=\"../home.php\">Back to home</a>";
    echo "<br><a href=\"outgoingform.php\">Add a product</a>";
}

?>