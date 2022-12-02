<?php

function obterConexao() {
    return pg_connect("host=localhost port=5432 user=Jeyson password=151709 dbname=mercadinho");
}
session_start();

function listarCategoria() {
    $sql = "select * from categoria order by id";
    $resultado = pg_query(obterConexao(), $sql);
    $dados = pg_fetch_all($resultado);
    return $dados;  
}

function inserirCategoria($nome){
    $sql = "insert into categoria(nome) 
    values ('$nome');";
    $resultado = pg_query(obterConexao(), $sql);
    return ['sucesso' => pg_affected_rows($resultado) > 0];
}

function excluirCategoria($id) {
    $sql = "delete from categoria where id = $id";
    $resultado = @pg_query(obterConexao(), $sql);
    
    return ['sucesso' => $resultado && pg_affected_rows($resultado) > 0];
}

function editarCategoria($id, $nome) {
    $sql = "update categoria
     set nome='$nome' 
     where id=$id";
     $resultado = pg_query(obterConexao(), $sql);
     return ['sucesso' => pg_affected_rows($resultado) > 0];
}

function listarProdutos(){
    $sqlProduto = <<<SQL
    select produto.id, produto.nome,produto.preco, produto.id_categoria, categoria.nome as nome_categoria
        from produto 
        left join categoria on categoria.id = produto.id_categoria  order by produto.id;
    SQL;
    $resultado = pg_query(obterConexao(), $sqlProduto);
    $dados = pg_fetch_all($resultado);
    return $dados;
}
function inserirProduto($nome, $preco, $categoria){
    $sql = <<<SQL
    insert into produto(nome, preco, id_categoria) values ('$nome', $preco, $categoria);
    SQL;
    $resultado = pg_query(obterConexao(), $sql);
    return ['sucesso' => pg_affected_rows($resultado) > 0];


}
function excluirProduto($id){
    $sql = "delete from produto where id = $id";
    $resultado = pg_query(obterConexao(), $sql);
    return ['sucesso' => pg_affected_rows($resultado) > 0];
}

function editarProduto($id, $nome, $preco, $categoria) {
    $sql = "update produto
    set(nome, preco, id_categoria) = ('$nome', $preco, $categoria)
    where id = $id;";
     $resultado = pg_query(obterConexao(), $sql);
     return ['sucesso' => pg_affected_rows($resultado) > 0];
}

function listarUsuarios(){
    $sql ="select * from usuario order by id;";
    $resultado = pg_query(obterConexao(), $sql);
    $dados = pg_fetch_all($resultado);
    return $dados;
}

function verificarUsuario($login, $senha){
    $sql = "select * from usuario where login = '$login' and senha = md5('$senha');";
    $resultado = pg_query(obterConexao(), $sql);
    $dados = pg_fetch_all($resultado);
    return $dados;
}

function inserirUsuario($nome, $funcao, $login, $senha){
    $sql = "insert into usuario(nome, funcao, login, senha) values ('$nome', '$funcao', '$login', md5('$senha'));";
    $resultado = pg_query(obterConexao(), $sql);
    return ['sucesso' => pg_affected_rows($resultado) > 0];
}

function excluirUsuario($id){
    $sql = "delete from usuario where id = $id";
    $resultado = pg_query(obterConexao(), $sql);
    return ['sucesso' => pg_affected_rows($resultado) > 0];
}

function editarUsuario($id, $nome, $funcao, $login, $senha) {
    $sql = "update usuario
    set(nome, funcao, login, senha) = ('$nome', '$funcao', '$login', md5('$senha'))
    where id = $id;";
     $resultado = pg_query(obterConexao(), $sql);
     return ['sucesso' => pg_affected_rows($resultado) > 0];
}

function adicionarAoCarrinho($id_produto, $id_venda, $quantidade, $preco){
    $sql = <<<SQL
    INSERT INTO produto_venda(id_produto, id_venda, quantidade, preco) VALUES ($id_produto, $id_venda, $quantidade, $preco);
    SQL;
    $resultado = pg_query(obterConexao(), $sql);
    return ['sucesso' => pg_affected_rows($resultado) > 0];
}


?>