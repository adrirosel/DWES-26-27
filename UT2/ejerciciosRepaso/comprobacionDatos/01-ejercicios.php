<?php

declare(strict_types=1);

$datos = 
    ['nombre' => 'Luis',
     'edad' => 0,
     'email' => null,
     'alias' => ''
    ];

// 1. Para cada clave (nombre, edad, email, ciudad, telefono), imprime con 
//var_dump el resultado de isset, array_key_exists y empty. Comprueba contra la tabla.

foreach (['nombre', 'edad', 'email', 'alias', 'telefono'] as $clave) {
    echo $clave . ': ';
    var_dump(isset($datos[$clave]));
    var_dump(array_key_exists($clave, $datos));
    var_dump(empty($datos[$clave]));
    echo '<br>';
}

//Para nombre va a ser: bool(true) bool(true) bool(false) 
//Para edad va a ser: bool(true) bool(true) bool(true)
//Para email va a ser: bool(false) bool(true) bool(true)
//Para alias va a ser: bool(true) bool(true) bool(true)
//Para telefono: bool(false) bool(false) bool(true)

// 2. Ponle a edad, email y alias un valor por defecto con ?? y luego con ?:. ¿En qué claves difieren? ¿Por qué?

echo $datos['edad'] ?? 'sin datos <br>' . '<br>';
echo $datos['edad'] ?: 'sin datos <br>' . '<br>';
//Para el primer, se va a imprimir el 0, para el segundo, sin datos

echo $datos['email'] ?? 'sin datos <br>' . '<br>';
echo $datos['email'] ?: 'sin datos <br>' . '<br>';
//Para el primer, se va a imprimir sin datos, para el segundo, sin datos tambien

echo $datos['alias'] ?? 'sin datos <br>' . '<br>';
echo $datos['alias'] ?: 'sin datos <br>' . '<br>';

//Para el primero, no se va a imprimir sin datos; para el segundo, sin datos

// 3. Usa ??= para añadir telefono con 'sin teléfono', y comprueba que no pisa nombre si haces $datos['nombre'] ??= 'X'.

$datos['telefono'] ??= 'sin telefono';

print_r($datos) . '<br>';

$datos['nombre'] ??= 'X';

print_r($datos) . '<br>';

// 4. Valida '42', '4.5', 'abc' y '0' con filter_var(..., FILTER_VALIDATE_INT). Para el '0', escribe el if correcto con === false.

$primerValor = filter_var('42', FILTER_VALIDATE_INT);

var_dump($primerValor);
//Va a devolver int(42)
echo '<br>';

$segundoValor = filter_var('4.5', FILTER_VALIDATE_INT);

var_dump($segundoValor);
//Va a devolver bool(false)
echo '<br>';

$tercerValor = filter_var('abc', FILTER_VALIDATE_INT);

var_dump($tercerValor);
//Va a devolver bool(false)
echo '<br>';

//Para el cuarto valor no se donde meter el if

$valor = filter_var('0', FILTER_VALIDATE_INT);
if($valor === false){
    echo 'valor no valido';
}

// 5. Escribe una función leerEdad(array $in): ?int que devuelva la edad como int si existe,
// es un entero válido y está entre 0 y 120, o null en cualquier otro caso.

function leerEdad(array $in): ?int{
    //Si la clave no existe, hacemos early return para evitar datos por argumento erroneos
    if(!isset($in['edad'])){
        return null;
    }
    //validamos la clave del array y le asignamos el rango
    $valor = filter_var($in['edad'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'max_range' => 120]]);
    //En el return hacemos la comparacion, si $valor es falsy, se convierte a null para evitar errores; sino, devuelve $valor
    return $valor === false ? null : $valor;
}

echo '<br>';
print_r(leerEdad($datos));