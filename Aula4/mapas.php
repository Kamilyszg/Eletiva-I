<?php
    $frutas = array("morango", "maça", "abacaxi"); //vetor clássico - índice inicia em 0

    echo "<p>".$frutas[0]."</p>"; //mostrar frutas em 0

    $frutas[0] = "laranja"; //frutas em 0 recebe laranja

    $frutas["fruta"] = 15; //criação de chave(índice) "fruta" - recebe int 15

    $cores[0] = "azul";
    $cores["cor"] = "laranja";

    $mapa= [
        //chave => valor da chave
        "valor1" => 1, 
        "valor2" => 2,
        "valor3" => 3
    ];

    //funções para exibir vetores
    var_dump($cores); //exibe chave, valor e o tipo de dado armazenado
    echo "<p></p>";

    print_r($mapa); //exibe chave e valor

    asort($frutas); //ordena o vetor pelo valor
    #ksort($frutas) - ordena o vetor pela chave

    #foreach($fruta as valor)
    foreach ($frutas as $chave => $valor) {
        echo "<p>Na posição $chave temos a fruta: $valor</p>";
    }
    
    echo "Quantidade de elementos: ".count($frutas);
?>