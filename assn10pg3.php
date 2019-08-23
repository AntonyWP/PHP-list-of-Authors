<?php
echo "<tr><th>List Of Authors ordered by last name </th></tr>";
echo "<table style='border: solid 1px black;'>";
echo "<tr><th>Author First Name</th><th>Author Last Name</th><th>";

class TableRows extends RecursiveIteratorIterator
{
    function __construct($it)
    {
        parent::__construct($it, self::LEAVES_ONLY);
    }

    function current()
    {
        return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
    }

    function beginChildren()
    {
        echo "<tr>";
    }

    function endChildren()
    {
        echo "</tr>" . "\n";
    }
}

$host = "courses";
$user = "z1624182";
$password = "1992Jul15";
$db = "henrybooks";

try
{
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT AuthorFirst, AuthorLast FROM Author ORDER by AuthorLast");
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v)
    {
        echo $v;
    }
}
catch(PDOException $e)
{
    echo "Error: " . $e->getMessage();
}
$conn = null;
echo "</table>";
include "footer.html";
?>
