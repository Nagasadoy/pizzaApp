<h1>ПИЦЦЫ</h1>
<?php
echo '<ul>';
foreach($pizzas as $pizza){
    echo '<li>'. $pizza->name ." (Цена: {$pizza->price} руб.)".'</li>';
    // var_dump($pizza->ingredients); die;
    $ingredients = $pizza->ingredients;
    echo '<ul>';
        foreach($ingredients as $ingredient){
            echo '<li>'. $ingredient->name .'</li>';
        }
    echo '</ul>';
}
echo '</ul>';
?>