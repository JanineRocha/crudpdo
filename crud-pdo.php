<?php
//-------------------Conexão--------------------//
try{

    $pdo = new PDO ("mysql:dbname=crudpdo;host=localhost", "root", "");

//bd name
//host
//usuario e senha
}catch (PDOException $e){

    echo "Erro com banco de dados: ".$e-> getMessage();

}
catch(Exception $e){

    echo "Erro generico: " .$e -> getMessage();
}

//-------------------Insert--------------------//
//1 primeira forma mais utilizada 'prepare' quando passamos algum paramêtro e precisamos dps substituir
// 

//$res = $pdo -> prepare("INSERT INTO pessoa(nome, telefone,email) VALUE (:n, :t, :e)");
//$res -> bindparam(":n","$nome");  bindparam só aceita assim variável

//$res -> bindValue(":n","Anne"); 
//$res -> bindValue(":t","578675898"); 
//$res -> bindValue(":e","anner@gmail.com");
//$res -> execute();

//2 segunda forma metódo "query" quando vc precisa passar a informação diretamente ou quando vc não tem paramêtros para passar
//quando não precisa fazer substituição não precisa de comando pra executar um execute(); só escrever um comando no 'query' e ele já executa.
//$pdo -> query("INSERT INTO pessoa(nome, telefone, email) VALUES ('Luis','44567895655','luis@gmail.com')")

//---------------------------------Delete e Update-----------------------------------//
//Para excluir os dados e atualizar
//$cmd = $pdo->prepare("DELETE FROM pessoa WHERE id = :id");
//$id = 2;
//$cmd->bindValue(":id",$id);
//$cmd->execute();
//ou

//$res = $pdo -> query("DELETE FROM pessoa WHERE id = '2'");

//-------------------------------------Select------------------------------------------//

//Buscar Informações e Exibir na Tela

$cmd = $pdo -> prepare("SELECT * FROM pessoa WHERE id = :id");
$cmd -> bindValue(":id",4);
$cmd -> execute();
$resultado = $cmd -> fetch(PDO::FETCH_ASSOC);
//$cmd -> fetch(); // apenas uma linha/ um id por pessoa
//ou
//$cmd -> fetchall(); // quando for mais de um registro
//echo "<pre>";
//print_r($resultado);
//echo "</pre>";
foreach ($resultado as $key => $value){

    //#code...

    echo $key.": ".$value."<br>";

}
?>



