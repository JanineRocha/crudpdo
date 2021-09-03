<?php
Class Pessoa{
    //6 funções ou 6 metódos
    
    private $pdo;
    //Conexão com banco de dados
    public function __construct($dbname, $host, $user, $senha){
        try{

            $this->pdo = new PDO("mysql:dbname=".$dbname.";host".$host,$user,$senha);

        }catch(PDOException $e){

            echo "Erro com banco de dados: ".$e->getMessage();
            exit();
        }
        catch(Exception $e){
            echo "Erro generico: ".$e-> getMessage();
            exit();
        } 
        
    }
    //Função para buscar dados e colocar no canto direito 
    public function buscarDados()
    {
        $res = array();
        //$cmd = $this -> pdo -> prepare("SELECT * FROM pessoa ORDER BY id ");
        //$cmd = $this -> pdo -> prepare("SELECT * FROM pessoa ORDER BY nome ");

        $cmd = $this -> pdo -> query("SELECT * FROM pessoa ORDER BY nome ");
        $res = $cmd -> fetchAll(PDO:: FETCH_ASSOC);
        return $res;
    }
    // Função de Cadastar pessoas no banco de dados
    public function cadastrarPessoa($nome, $telefone, $email)
    {
        // Antes de cadastar verificar se ja tem o email cadastrado
        $cmd = $this -> pdo -> prepare("SELECT id from pessoa where email = :e");
        $cmd -> bindValue(":e", $email);
        $cmd -> execute();
        if($cmd -> rowCount() > 0)// email já existe no banco
        {
            return false;
        } else // não foi encontrado o email
        {
            $cmd = $this -> pdo ->prepare("INSERT INTO pessoa (nome, telefone, email) VALUES (:n, :t, :e)");
            $cmd -> bindValue(":n", $nome);
            $cmd -> bindValue(":t", $telefone);
            $cmd -> bindValue(":e", $email);
            $cmd -> execute();
            return true;
        }
    }

    public function excluirPessoa($id)
    {
        $cmd = $this -> pdo -> prepare ("DELETE FROM pessoa WHERE id =:id");
        $cmd -> bindValue(":id", $id);
        $cmd -> execute();
    }
    //Buscar Dados de Uma Pessoa 
    public function buscarDadosPessoa($id)
    {
        $res = array();
        $cmd = $this -> pdo -> prepare ("SELECT *FROM pessoa WHERE id = :id");
        $cmd -> bindValue(":id", $id);
        $cmd -> execute();
        //$res = $cmd-> fetchAll(PDO::FETCH_ASSOC); // quando é mais de um registro
        $res = $cmd-> fetch(PDO::FETCH_ASSOC); // quando é mais de um registro // PDO::FETCH_ASSOC para economizar memória // como agente vai utilizar os nomes e não as posições 0123, então agente usa o PDO::FETCH_ASSOC
        return $res;
    }

    //Atualizar Dados no Banco de Dados
    public function atualizarDados($id, $nome, $telefone, $email)// variável p/ fazer um filtro e atualizar
    {
       
        $cmd = $this -> pdo -> prepare ("UPDATE pessoa SET nome = :n, telefone = :t, email = :e WHERE id = :id"); // Nunca se esquça de atualizar pelo id, tomar cuidade ao não utilizar a cláusula WHERE se não ele vai atualizar a tabela inteira
        $cmd -> bindValue(":n",$nome); // bindvalue serve para substituir
        $cmd -> bindValue(":t",$telefone);
        $cmd -> bindValue(":e",$email);
        $cmd -> bindValue(":id", $id);
        $cmd -> execute();
      
    }
}
?>