<?php

$host= 'localhost';
$dbname= 'zoologico';
$username= 'root';
$password= '';

try{

    $pdo = new PDO ("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexão bem sucedida!";

}catch(PDOException $e){
    die("Erro na conexão: ".$e->getMessage());    
}

function listarAnimais(): array{
    global $pdo;
    $stmt = $pdo->query('SELECT * FROM animais');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function adicionarAnimal($nome, $especie, $idade, $habitat): void{
    global $pdo;
    $stmt = $pdo-> prepare('INSERT INTO animais (nome, especie, idade, habitat) VALUES (:nome, :especie, :idade, :habitat)');
    $stmt- > bindParam(param: 'nome', var: & $nome);
    $stmt- > bindParam(param: 'especie', var: & $especie);
    $stmt- > bindParam(param: 'idade', var: & $idade, type: PDO::PARAM_INT);
    $stmt- > bindParam(param: 'habitat', var: & $habitat);

    if($stmt->execute()){
        echo "Animal registrado com sucesso!";
    }else{
        echo "Erro ao registrar animal!";
    }
}
?>