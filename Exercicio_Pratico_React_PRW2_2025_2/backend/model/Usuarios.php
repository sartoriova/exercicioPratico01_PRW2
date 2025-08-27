<?php

require_once(__DIR__ . "/../configs/Database.php");
require_once(__DIR__ . "/../configs/utils.php");


class Usuarios
{
    public static function inserir($nome)
    {
        try {
            $conexao = Conexao::getConexao();

            $stmt = $conexao->prepare("INSERT INTO usuarios(nome) VALUES (?)");
            $stmt->execute([$nome]);
            return  $stmt->rowCount();
        } catch (Exception $e) {
            output(500, ["msg" => $e->getMessage()]);
        }
    }

    public static function existe_by_id($id)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT COUNT(*) as qtde FROM usuarios WHERE id = ?");
            $stmt->execute([$id]);

            return $stmt->fetchColumn();
        } catch (Exception $e) {
            output(500, ["msg" => $e->getMessage()]);
        }
    }

    public static function remover($id)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("DELETE FROM usuarios WHERE id = ?");
            $stmt->execute([$id]);

            return $stmt->rowCount();
        } catch (Exception $e) {
            output(500, ["msg" => $e->getMessage()]);
        }
    }

    public static function listar()
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT * FROM usuarios");
            $stmt->execute();

            $usuarios = $stmt->fetchAll();

            foreach ($usuarios as &$usuario) {
                $stmtProduto = $conexao->prepare("SELECT p.id, p.nome, p.preco FROM compras c JOIN produtos p ON c.id_produto = p.id WHERE c.id_usuario = ?");
                $stmtProduto->execute([$usuario["id"]]);
                $usuario["produtos"] = $stmtProduto->fetchAll();
            }

            return $usuarios;
        } catch (Exception $e) {
            output(500, ["msg" => $e->getMessage()]);
        }
    }
}
