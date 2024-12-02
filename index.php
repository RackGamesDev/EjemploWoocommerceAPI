<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php
//Instalar composer
//composer init
//Todo yes
//Composer require automattic/woocommerce
    require __DIR__ . '/vendor/autoload.php';
    use Automattic\WooCommerce\Client;
    $woocommerce = new Client(
        'https://pruebawpf0000.server2.trinchera.dev/',//url de la pagina con wordpress y woocommerce
        'ck_ec4579db85ddb43fbf05845da6108b547217514f',//claves de la api
        'cs_ba9013beed4a110d297f18889c1167d12ecdd663',
        [
            'wp_api' => true,
            'version' => 'wc/v3',
            'query_string_auth' => true
        ]
    );
    //Toda la informacion sobre la base de datos y la API en https://woocommerce.github.io/woocommerce-rest-api-docs/?php 
?>


<?php
    //RECOGER DATOS
    $data = json_encode($woocommerce->get('products'));//Especificar que base de datos recoger
    $data = json_decode($data, true); 
?>
<ul>
<?php foreach ($data as $row) : ?><!--Devuelve un array con cada entrada de x cosa, por lo tanto esto lo recorre en un bucle (cada item por iteracion)-->
<li><?= $row['name'] ?> : <?= $row['id'] ?></li><!--Recoger una propiedad en especifico y ponerla en el html-->
<?php endforeach; ?>
</ul>
<?php
    print_r($woocommerce->get('products/17'));//Para sacar los datos de un producto concreto a partir de su ID
?>


<?php
    //CAMBIAR DATOS
    $data = [//Payload con los nuevos datos (mirar cada atributo)
        'regular_price' => '24.54'
    ];
    $woocommerce->put('products/17', $data);//Subir el payload a cierto producto(o lo que sea) usando su ID, una respuesta de esta funcion indica que fue todo bien
?>


<?php
    //BORRAR ENTRADA
    $woocommerce->delete('products/17', ['force' => true]);//Borrar cierto producto(o la entrada que sea) usando su ID, una respuesta de esta funcion indica que fue todo bien
?>


<?php
    //CREAR ENTRADA
    $data = [//Payload con los datos minimos para crear el producto (o lo que sea)
        'name' => 'Premium Quality',
        'type' => 'simple',
        'regular_price' => '21.99',
        'description' => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.',
        'short_description' => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.'
    ];
    $woocommerce->post('products', $data);//subir el payload para crear una nueva entrada (no hay que especificar ID, se crea solo en teoria), una respuesta de esta funcion indica que fue todo bien
?>
</body>
</html>
