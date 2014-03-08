<?php


return array(
    'classes' => array(
		array(
			'uri' => '/soap',
			'class' => array(
				'name' => 'SoapTeste',
				'methods' => array(
					'hello' => array(					
						'annotation' => "\n/**\n* Método Hello\n*\n* @param string \$algumacoisa\n* @return string\n*/\n",
						'parameters' => array('$algumacoisa'),
						'bodyBlock' => "\$retString = 'Bem vindo ' . \$algumacoisa; ",
						'returns' => "\$retString;"
					)
				)
			)
		)
    )
);
