<?php

namespace App\Models;

use PDOException;
use PDO;

class Model
{

    protected object $connect;
    protected $id;
    protected string $table_name = "usuarios";
    /**
     * Conecta ao banco de dados ou retorna conexão já existente
     *
     * @return PDO
     */
    protected function connect(): PDO
    {

        if (!empty($this->connect)) {
            return $this->connect;
        }

        $host = $_ENV['DB_HOST'];
        $db_name = $_ENV['DB_NAME'];
        $user = $_ENV['DB_USER'];
        $pass = $_ENV['DB_PASSWORD'];
        $port = $_ENV['DB_PORT'];

        try {
            $this->connect = new PDO('mysql:host=' . $host . ';port=' . $port . ';dbname=' . $db_name, $user, $pass);
            $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->connect;
        } catch (PDOException $e) {
            // Apenas quando estiver desenvolvendo
            die("Erro: " . $e->getMessage());
        }
    }

    /**
     * Método responsável por inserir dados no banco
     * @param array $values [field => value]
     * @return boolean
     */
    public function insert(array $values): bool
    {
        $fields = array_keys($values);
        $binds  = array_pad([], count($fields), '?');
        $sql = "INSERT INTO `$this->table_name` (" . implode(',', $fields) . ') VALUES (' . implode(',', $binds) . ');';
        $db = $this->connect();
        $query = $db->prepare($sql);
        if ($query->execute(array_values($values))) {
            $this->id = $db->lastInsertId();
            return true;
        }
        return false;
    }

    /**
     * Método responsável por excluir dados do banco
     * @param string|array $where
     * @return boolean
     */
    public function delete(string|array $where): bool
    {
        if (is_array($where)) {
            $fields_where = array_keys($where);
            $params = array_values($where);
            $text = 'WHERE ';
            for ($i = 0; $i < count($fields_where); $i++) {
                $text .= "$fields_where[$i] = '$params[$i]' ";
                if ($i + 1 != count($fields_where)) {
                    $where = 'AND ';
                }
            }
        } else {
            $text = "WHERE $where";
            $params = [];
        }
        $sql = "DELETE FROM `$this->table_name` $text;";
        $query = $this->connect()->prepare($sql);
        return ($query->execute());
    }

    /**
     * Pega dados do banco de dados
     *
     * @param mixed $where
     * @param integer|null $limit
     * @param string $fields
     * @param string|null $order
     * @return mixed
     */
    public function select(mixed $where = '', ?int $limit = null, string $fields = '*', string $order = null): mixed
    {
        if (is_array($where)) {
            $fields_where = array_keys($where);
            $params = array_values($where);
            $text = 'WHERE ';
            for ($i = 0; $i < count($fields_where); $i++) {
                $text .= "{$fields_where[$i]} = '{$params[$i]}' ";
                if ($i + 1 != count($fields_where)) {
                    $where = 'OR ';
                }
            }
        } elseif (!empty($where)) {
            $text = 'WHERE ' . $where;
            $params = [];
        } else {
            $text = '';
            $params = [];
        }
        $order = !empty($order) ? "ORDER BY $order" : '';
        $limit = !empty($limit) ? "LIMIT $limit" : '';
        $sql = "SELECT $fields FROM `$this->table_name` $text $limit $order;";
        $db = $this->connect();
        return $db->query($sql);
    }


    /**
     * Método responsável por executar atualizações no banco de dados
     * @param array|string $values [field => value]
     * @param string $where
     * @return boolean
     */
    public function update(array|string $values, string $where = ''): bool
    {
        $where = !empty($where) ? " WHERE $where" : '';
        if (is_array($values)) {
            $fields = array_keys($values);
            $sql = "UPDATE `$this->table_name` SET " . implode('=?,', $fields) . "=? $where;";
            $query = $this->connect()->prepare($sql);
            return ($query->execute(array_values($values)));
        } else {
            $sql = "UPDATE `$this->table_name` SET $values $where;";
            $query = $this->connect()->prepare($sql);
            return ($query->execute());
        }
    }
}
