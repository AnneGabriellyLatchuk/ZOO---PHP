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
    $stmt = $pdo->prepare('INSERT INTO animais (nome, especie, idade, habitat) VALUES (:nome, :especie, :idade, :habitat)');
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':especie', $especie);
    $stmt->bindParam(':idade', $idade, PDO::PARAM_INT);
    $stmt->bindParam(':habitat', $habitat);

    if($stmt->execute()){
        echo "Animal registrado com sucesso!";
    }else{
        echo "Erro ao registrar animal!";
    }
}

function editarAnimal($id, $nome, $especie, $idade, $habitat) {
    global $pdo; // Acessa a variável PDO
    $stmt = $pdo->prepare("UPDATE animais SET nome = :nome, especie = :especie, idade = :idade, habitat = :habitat WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':especie', $especie);
    $stmt->bindParam(':idade', $idade, PDO::PARAM_INT);
    $stmt->bindParam(':habitat', $habitat);
    
    if ($stmt->execute()) {
        echo "Animal atualizado com sucesso!";
    } else {
        echo "Erro ao atualizar o animal.";
    }
}

function excluirAnimal($id) {
    global $pdo; // Acessa a variável PDO
    $stmt = $pdo->prepare("DELETE FROM animais WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        echo "Animal excluído com sucesso!";
    } else {
        echo "Erro ao excluir o animal.";
    }
}

// 8. Teste para verificar se a função está sendo executada
if (isset($_GET['teste'])) {
    adicionarAnimal('Tigre', 'Felino', 4, 'Floresta');
    echo "Animal adicionado!";
}

// 9. Teste para listar os animais
$animais = listarAnimais();
echo '<pre>';
print_r($animais); // Exibe a lista de animais

echo "\nFim do script.";
?>