// Ejemplo 4.- Fibonacci
<?php

$a = 0;
$b = 1;
$suma = "";

echo $a. " " . $b. " ";

for ($i = 0; $i < 10; $i++ ){
$suma = $a + $b;
echo $suma. " ";

$a = $b;
$b = suma;
}

?>

// Ejemplo 5.- Invertir una cadena de texto

<?php
$texto = "hola";
$invertido = strrev($texto);
echo $invertido;
?>
