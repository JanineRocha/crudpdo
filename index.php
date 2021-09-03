<?php
require_once 'classe-pessoa.php';
$p = new Pessoa("crudpdo","localhost", "root", "");
?>

<!DOCTYPE html5>
<html lang="pt-br">
    <head>
 <meta charset="utf-8">
    <title>Cadastro de Pessoas</title>
    <link rel="stylesheet" href="estilo.css">
    </head>
    <body>
        <?php
        if(isset($_POST['nome']))
        //Clicou no Botão editar
        {
            //----------------------------Editar---------------------------//
            if(isset($_GET['id_up']) && !empty($_GET['id_up']))
            {
                $id_upd =addslashes($_GET['id_up']);
                $nome = addslashes($_POST['nome']);
                $telefone = addslashes($_POST['telefone']);
                $email = addslashes($_POST['email']);
                if(!empty($nome) && !empty($telefone) && !empty($email))
                {
                    //Editar
                    $p->atualizarDados($id_upd, $nome, $telefone, $email); // usar a mesma ordem que está na função
                    {
                       echo "Email já esta cadastrado!";
                    }
                }
                else
                {
                    echo "Preencha todos os campos!";
                }
            }
        }
            
            //----------------------------Cadastrar------------------------//
            if(isset($_POST['nome']))
            //Clicou no Botão cadastrar ou editar
             {
                $nome = addslashes($_POST['nome']);
                $telefone = addslashes($_POST['telefone']);
                $email = addslashes($_POST['email']);
                if(!empty($nome) && !empty($telefone) && !empty($email))
                { //cadastrar
                    if(!$p->cadastrarPessoa($nome, $telefone, $email))
                    {
                        echo "Cadastrado com sucesso!";
                   }
                    else
                    {
                        echo "Email já esta cadastrado!";
                    }
                }
                else
                {
                    echo "Preencha todos os campos!";
                }
        }
            ?>
        <?php
        if(isset($_GET['id_up'])) //Esse if verifica se a pessoa clicou em editar, ele só vai realizar o que está dentro do bloco se existir esse id_up, caso contrário ele n vai fazer nada.
        {
           $id_update = addslashes($_GET['id_up']); // armazenar essa informação sempre utilizando addslashes a informação já está guardade na variável id_up date então agora é só enviar p/ função 
           $res = $p -> buscarDadosPessoa($id_update); // objeto chamado p vamos acessão a função buscar dados pessoa/ $res pra receber o retorno dos dados agora é só distribuir as informções no input utizando  o atributo value
        }
        ?>
        <section id="esquerda">
    <form method="POST">
        <h2>Cadastrar Pessoa</h2>
        <label for="nome">NOME</label>
        <input type="text" name="nome" id="nome" value = "<?php if(isset($res)){echo $res['nome'];}?>"> 
        <label for="telefone">TELEFONE</label>
        <input type="text" name="telefone" id="telefone" value = "<?php if(isset($res)){echo $res['telefone'];}?>">
        <label for="email">EMAIL</label>
        <input type="email" name="email" id="email" value = "<?php if(isset($res)){echo $res['email'];}?>">
        <input type="submit" value="<?php if(isset($res)){echo "Atualizar";}else{echo "Cadastrar";} ?>">
       
    </form>
        </section>
        
        <section id="direita">
        <table>
                <tr id="titulo">
                    <div class="">
                    <td>Nome</td>
                    <td>Telefone</td>
                    <td>Email</td>
                    <td colspan="3">Opções</td>
                    </div>
                </tr>
            <?php
                $dados = $p -> buscarDados();
                if(count($dados) > 0) // Tem pessoas no banco de dados
                {
                    for($i=0; $i < count($dados); $i++)
                    {
                        echo "<tr>";
                        foreach ($dados[$i] as $k => $v)
                        {
                            if($k != "id")
                            {
                                echo "<td>".$v."</td>";
                            }

                        }
                        ?>
                        <td>
                        <a href="index.php?id_up=<?php echo $dados[$i]['id'];?>">Editar</a>
                        </td>
                         <td>
                             <a href="index.php?id=<?php echo $dados[$i]['id'];?>">Excluir</a>
                        </td>
                         <?php
                         echo "</tr>";                       
                    }                 
                }
                else // O Banco de dados está vazio
                {
                    echo "Ainda não há pessoas cadastradas! ";
                }
                   //echo "<pre>";
                //var_dump($dados);
                //echo "</pre>";
                
                ?>
            </table>
        </section>
    </body>
</html>
<?php

    if(isset($_GET['id']))
    {
        $id_pessoa = addslashes($_GET['id']);
        $p -> excluirPessoa($id_pessoa);
        header("location: index.php");
    }
?>