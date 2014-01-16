<?php


return array(
    'classes' => array(
        'uri' => '/soap',
        'class' => array(
            'name' => 'SoapTeste',
            'methods' => array(
                'hello' => array(
                    'comments' => "\n/**\n* Método Hello\n*\n* @param string \$algumacoisa\n* @return string\n*/\n",
                    'parameters' => array('$algumacoisa'),
                    'returns' => "\$algumacoisa . ' Bem vindo';"
                )
            )
        )
    )
);
