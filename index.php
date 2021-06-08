<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>task5</title>
</head>


<body>
    <?php include './php/connect.php';
    // echo 'баланс пользователей ' . ' <br>';
    // $stmt = $pdo->query('SELECT balans FROM  persons');
    // $data = $stmt->fetchAll();
    // $balans_arr = [];
    // foreach ($data as $value) {
    //     echo $value['balans'] . '<br />';
    //     array_push($balans_arr, $value['balans']);
    // }


    // for ($i = 0; $i < count($balans_arr); $i++) {
    //     echo ($balans_arr[$i] + 1000);
    //     echo '<br>';
    // }

    //$stmt = $pdo->query('UPDATE persons SET balans = balans + 1000');

    $stmt = $pdo->query('SELECT amount FROM  transactions');
    $data = $stmt->fetchAll();



    echo 'б) написать запрос, который бы выводил полное имя и баланс человека на данный момент' . '<br>';
    $stmt = $pdo->query('SELECT fullname, balans FROM  persons');
    $data = $stmt->fetchAll();
    foreach ($data as $value) {
        echo $value['fullname'] . '----' . $value['balans'] . '<br />';
    }



    echo 'в) написать запрос, который бы выводил имя человека, который участвовал в передаче денег наибольшее количество раз' . '<br>';

    $stmt = $pdo->query('SELECT transactions.from_person_id, COUNT(*) AS Cnt FROM transactions GROUP BY transactions.from_person_id ORDER BY Cnt DESC LIMIT 1
');
    $data = $stmt->fetchAll();
    foreach ($data as $value) {
        //echo $value['from_person_id'];
        $sql = 'SELECT persons.fullname FROM persons WHERE persons.id = :from_person_id ';
        $stmt = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $stmt->execute(array(':from_person_id' => $value['from_person_id']));
        $name = $stmt->fetchAll();
        foreach ($name as $value) {
            echo $value['fullname'];
            echo ' ----- участвовал в передаче денег наибольшее количество раз' . '<br>';
        }
    }
    echo 'г) написать запрос, отражающий все транзакции, где передача денег осуществлялась между представителями одного города' . '<br>';

    echo 'транзакции кто передаёт деньги' . '<br>';
    $stmt = $pdo->query('SELECT transactions.amount, persons.fullname, city.name FROM transactions JOIN persons, city WHERE transactions.from_person_id = persons.id AND persons.id = city.id ORDER BY city.name');
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($data as $key => $value) {
        // var_dump($value); 
        // echo'<br>';
        echo $value['amount'] . '-----';

        echo $value['fullname'] . '-----';

        echo $value['name'];
        echo '<br>';
    }
    echo 'транзакции кто получал деньги' . '<br>';
    $stmt = $pdo->query('SELECT transactions.amount, persons.fullname, city.name FROM transactions JOIN persons, city WHERE transactions.to_person_id = persons.id AND persons.id = city.id ORDER BY city.name');
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($data as $key => $value) {
        // var_dump($value); 
        // echo'<br>';
        echo $value['amount'] . '-----';

        echo $value['fullname'] . '-----';

        echo $value['name'];
        echo '<br>';
    }
    $pdo = null;
    ?>

</body>

</html>