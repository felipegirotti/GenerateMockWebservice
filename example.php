<?php

/* 
 * Para rodar este exemplo renomeie o arquivo config.php.example para config.php
 * e sete a variável servidor
 */

$servidor = 'http://localhost:8000';

$client = new \SoapClient($servidor . '/soap?wsdl');
echo '<pre>';
var_dump('Resultado', $client->hello('Felipe'));
echo '</pre>';

