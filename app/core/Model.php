<?php

namespace app\core;

use Exception;
abstract class Model
{
    protected $db;
    protected $tabela;

    public function __construct()
    {
        $this->db = Conexao::getConexao();
    }
    //Ultima data compensação
    function findCompensado($conn, $tabela, $campoAgregacao, $campo, $valor, $id_corretora)
    {
        $tabela = ($tabela) ? $tabela : $this->tabela;
        try {
            $sql = "SELECT max($campoAgregacao) as max FROM " . $tabela . " WHERE id_user = " . $_SESSION[SESSION_LOGIN]->id_user . " AND id_corretora = " . $id_corretora . " AND confirma = 'S'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }
    function findCredito($conn, $tabela, $campoAgregacao, $campo, $valor, $id_corretora)
    {
        $tabela = ($tabela) ? $tabela : $this->tabela;
        try {
            $sql = "SELECT sum($campoAgregacao) as soma FROM " . $tabela . " WHERE id_user = " . $_SESSION[SESSION_LOGIN]->id_user . " AND id_corretora = " . $id_corretora;
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }
    function findDebito($conn, $tabela, $campoAgregacao, $campo, $valor, $id_corretora)
    {
        $tabela = ($tabela) ? $tabela : $this->tabela;
        try {
            $sql = "SELECT sum($campoAgregacao) as soma FROM " . $tabela . " WHERE id_user = " . $_SESSION[SESSION_LOGIN]->id_user . " AND id_corretora = " . $id_corretora . " AND confirma = 'S'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }
    //Soma saldos conta corrente 
    function findAcompensar($conn, $tabela, $campoAgregacao, $campo, $valor, $id_corretora)
    {
        $tabela = ($tabela) ? $tabela : $this->tabela;
        try {
            $sql = "SELECT sum($campoAgregacao) as soma FROM " . $tabela . " WHERE id_user = " . $_SESSION[SESSION_LOGIN]->id_user . " AND id_corretora = " . $id_corretora . " AND confirma = 'N'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }
    function all3($conn, $tabela = null, $id_corretora = null)
    {

        $tabela = ($tabela) ? $tabela : $this->tabela;
        try {
            $sql = "SELECT * FROM " . $tabela . " WHERE confirma = 'N' AND id_user = " . $_SESSION[SESSION_LOGIN]->id_user . " AND id_corretora = " . $id_corretora;

            $stmt = $conn->query($sql);
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }
    //corrente
    function findLikeC($conn, $campo, $valor, $id_corretora, $tabela = null, $isLista = false, $posicao = null)
    {
        $tabela = ($tabela) ? $tabela : $this->tabela;

        try {

            $sql = "SELECT * FROM " . $tabela . " WHERE " . $campo . " like :campo AND id_user = " . $_SESSION[SESSION_LOGIN]->id_user . " AND id_corretora = " . $id_corretora;


            $stmt = $conn->prepare($sql);


            if (!$posicao) {
                $stmt->bindValue(":campo", "%" . $valor . "%");
            } else {
                if ($posicao == 1) {

                    $stmt->bindValue(":campo", $valor . "%");
                } else {

                    $stmt->bindValue(":campo", "%" . $valor);
                }
            }
            if ($campo === "cod_despesa") {
                $stmt->bindValue(":campo", $valor);
            }
            $stmt->execute();
            if ($isLista) {
                return $stmt->fetchAll(\PDO::FETCH_OBJ);
            } else {
                return $stmt->fetch(\PDO::FETCH_OBJ);
            }
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }


    //Serve para fazer consultas utilizando parametros
    function consultar($conn, $sql, $parametro = array(), $isLista = true)
    {
        $stmt = $conn->prepare($sql);
        if (!$parametro) {
            throw new  Exception("É necessário enviar os parâmetros para o método consultar");
        }

        try {
            foreach ($parametro as $chave => $valor) {
                $stmt->bindValue(":$chave", $valor);
            }
            $stmt->execute();
            if ($isLista) {
                return $stmt->fetchAll(\PDO::FETCH_OBJ);
            } else {
                return $stmt->fetch(\PDO::FETCH_OBJ);
            }
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    //Serve para fazer consultas diversas, sem parâmetros
    function select($conn, $sql, $isLista = true)
    {
        try {
            $stmt = $conn->query($sql);
            if ($isLista) {
                return $stmt->fetchAll(\PDO::FETCH_OBJ);
            } else {
                return $stmt->fetch(\PDO::FETCH_OBJ);
            }
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    //Retorna uma lista da tabela
    function all($conn, $tabela = null)
    {
        $tabela = ($tabela) ? $tabela : $this->tabela;
        try {
            if ($tabela == "pedidoo") {
                $tabela = "pedido";
                $sql = "SELECT * FROM " . $tabela . " WHERE cliente <> '' AND pago = 'N' AND encomendas = 'N' ORDER BY cliente";
            } else if ($tabela == "producao") {
                $tabela = "pedido";
                $sql = "SELECT * FROM " . $tabela . " WHERE pago = 'N' AND cliente <> '' AND encomendas = 'S' ORDER BY data_encomendas";
            } else if ($tabela == "comprasFat") {
                $tabela = "compras";
                $sql = "SELECT *, ( select nm_nome from fornecedor where fornecedor.id_fornecedor = compras.id_fornecedor) as nm_nome FROM " . $tabela . " WHERE nf_faturado = 'N' ORDER BY data_nf";
            } else if ($tabela == "pedidoe") {
                $tabela = "pedido";
                $sql = "SELECT * FROM " . $tabela . " WHERE cliente <> '' AND pago = 'N' AND encomendas = 'S' ORDER BY cliente";
            } else if ($tabela == "userAdm") {
                $tabela = "user";
                $sql = "SELECT * FROM " . $tabela . " WHERE id_user <> 1  ORDER BY login";
            } else if ($tabela == "salario1") {
                $tabela = "salario";
                $sql = "SELECT *, ( select nm_nome from funcionario where funcionario.id_funcionario = salario.id_funcionario) as nm_nome FROM " . $tabela . " WHERE sl_vigente = 'S'";
            } else if ($tabela == "salarioac1") {
                $tabela = "salarioac";
                $sql = "SELECT *, ( select nm_nome from funcionario where funcionario.id_funcionario = salarioac.id_funcionario) as nm_nome FROM " . $tabela . " WHERE folha_ab = 'S'";
            } else if ($tabela == "salariodb1") {
                $tabela = "salariodb";
                $sql = "SELECT *, ( select nm_nome from funcionario where funcionario.id_funcionario = salariodb.id_funcionario) as nm_nome FROM " . $tabela . " WHERE folha_ab = 'S'";
            } else if ($tabela == "relatorios") {
                $tabela = "caixaabre";
                $custo = "custo";
                $valor = "valor";
                $sql = "SELECT *, ( select sum($custo) from pedido where pedido.id_caixaabre = caixaabre.id_caixaabre AND quant = 0) as custo, ( select sum($valor) from pedido where pedido.id_caixaabre = caixaabre.id_caixaabre AND quant = 0) as valor FROM " . $tabela . " WHERE fechado = 'S'";
            } else if ($tabela == "salariofolha1") {
                $tabela = "salariofolha";
                $salario = "salario";
                $acrescimo = "ac_valor";
                $debito = "db_valor";
                $sql = "SELECT *, ( select sum($salario) from salario where salario.sl_vigente = 'S') as salario, ( select sum($acrescimo) from salarioac where salarioac.ac_data_deb = salariofolha.data_folha) as acrescimo, ( select sum($debito) from salariodb where salariodb.db_data_deb = salariofolha.data_folha) as debito FROM " . $tabela . " WHERE folha_ab = 'S'";
            } else if ($tabela == "salariofolha2") {
                $tabela = "salariofolha";
                $salario = "salario";
                $acrescimo = "ac_valor";
                $debito = "db_valor";
                $sql = "SELECT *, ( select sum($salario) from salario where salario.sl_vigente = 'S') as salario, ( select sum($acrescimo) from salarioac where salarioac.ac_data_deb = salariofolha.data_folha) as acrescimo, ( select sum($debito) from salariodb where salariodb.db_data_deb = salariofolha.data_folha) as debito FROM " . $tabela . " WHERE folha_ab = 'N'";
            } else if ($tabela == "pedidosAreceber") {
                $tabela = "pedido";
                $custo = "custo";
                $quant = "quant";
                $sql = "SELECT * FROM " . $tabela . " WHERE cliente <> '' AND pago = 'N'";
            } else if ($tabela == "relatorios3") {
                $tabela = "caixaabre";
                $custo = "custo";
                $valor = "valor";
                $dataIn = $_SESSION["dataIn"];
                $dataFim = $_SESSION["dataFim"];
                $sql = "SELECT *, ( select sum($custo) from pedido where pedido.id_caixaabre = caixaabre.id_caixaabre AND quant = 0) as custo, ( select sum($valor) from pedido where pedido.id_caixaabre = caixaabre.id_caixaabre AND quant = 0) as valor FROM " . $tabela . " WHERE fechado = 'S' AND data_ab_caixa between '$dataIn' AND '$dataFim'";
            } else if ($tabela == "apagarDatas2") {
                $tabela = "faturas";
                $dataIn = $_SESSION["dataIn"];
                $dataFim = $_SESSION["dataFim"];
                $sql = "SELECT *, (select nm_nome from fornecedor where fornecedor.id_fornecedor = faturas.id_fornecedor) as fornecedor FROM " . $tabela . " WHERE ft_paga = 'N' AND ft_venc between '$dataIn' AND '$dataFim'";
            } else if ($tabela == "apagarDatas3") {
                $tabela = "faturas";
                $dataIn = $_SESSION["dataIn"];
                $dataFim = $_SESSION["dataFim"];
                $sql = "SELECT *, (select nm_nome from fornecedor where fornecedor.id_fornecedor = faturas.id_fornecedor) as fornecedor FROM " . $tabela . " WHERE ft_paga = 'S' AND ft_venc between '$dataIn' AND '$dataFim'";
            } else if ($tabela == "compras") {
                $sql = "SELECT *, ( select nm_nome from fornecedor where fornecedor.id_fornecedor = compras.id_fornecedor) as fornecedor FROM " . $tabela;
            } else if ($tabela == "faturasapg") {
                $tabela = "faturas";
                $ft_valor = "ft_valor";
                $sql = "SELECT *, (select nm_nome from fornecedor where fornecedor.id_fornecedor = faturas.id_fornecedor) as fornecedor FROM " . $tabela . " WHERE ft_paga = 'N'";
            } else if ($tabela == "faturaspag") {
                $tabela = "faturas";
                $ft_valor = "ft_paga";
                $sql = "SELECT *, (select nm_nome from fornecedor where fornecedor.id_fornecedor = faturas.id_fornecedor) as fornecedor FROM " . $tabela . " WHERE ft_paga = 'S'";
            } else if ($tabela == "relatorios2") {
                $tabela = "pedido";
                $custo = "custo";
                $valor = "valor";
                $sql = "SELECT * FROM " . $tabela . "WHERE ";
            } else if ($tabela == "fornecedorOr") {
                $tabela = "fornecedor";
                $sql = "SELECT * FROM " . $tabela . " ORDER BY nm_nome ";
            } else {
                $sql = "SELECT * FROM " . $tabela;
            }
            $stmt = $conn->query($sql);
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    //Retorna uma consulta por um campo
    function find($conn, $campo, $valor, $tabela = null, $isLista = false)
    {

        $tabela = ($tabela) ? $tabela : $this->tabela;
        try {
            if ($tabela == "pedidodia") {
                $tabela = "pedido";
                $sql = "SELECT * FROM " . $tabela . " WHERE " . $campo . " =:campo AND cliente = ''";
            } else if ($tabela == "salarioVig") {
                $tabela = "salario";
                $sql = "SELECT * FROM " . $tabela . " WHERE sl_vigente = 'S' AND " . $campo . " =:campo ";
            } else if ($tabela == "salarioVg") {
                $tabela = "salario";
                $sql = "SELECT * FROM " . $tabela . " WHERE sl_vigente = 'S' AND " . $campo . " =:campo ";
            } else if ($tabela == "salario2") {
                $tabela = "salario";
                $sql = "SELECT *, (select nm_nome from funcionario where funcionario.id_funcionario = salario.id_funcionario) as nm_nome, (select foto from funcionario where funcionario.id_funcionario = salario.id_funcionario) as foto FROM " . $tabela . " WHERE " . $campo . " =:campo ";
            } else if ($tabela == "salarioac2") {
                $tabela = "salarioac";
                $sql = "SELECT *, (select nm_nome from funcionario where funcionario.id_funcionario = salarioac.id_funcionario) as nm_nome, (select foto from funcionario where funcionario.id_funcionario = salarioac.id_funcionario) as foto FROM " . $tabela . " WHERE " . $campo . " =:campo ";
            } else if ($tabela == "salariodb2") {
                $tabela = "salariodb";
                $sql = "SELECT *, (select nm_nome from funcionario where funcionario.id_funcionario = salariodb.id_funcionario) as nm_nome, (select foto from funcionario where funcionario.id_funcionario = salariodb.id_funcionario) as foto FROM " . $tabela . " WHERE " . $campo . " =:campo ";
            } else if ($tabela == "pedidoCli_p") {
                $tabela = "pedido";
                $sql = "SELECT * FROM " . $tabela . " WHERE " . $campo . " =:campo ";
            } else if ($tabela == "pedidoD") {
                $tabela = "pedido";
                $sql = "SELECT * FROM " . $tabela . " WHERE " . $campo . " =:campo AND cx_fechado = 'S'";
            } else if ($tabela == "pedidoAreceberClilt") { // aqui
                $tabela = "pedido";
                $campo = "nr_pedido";
                $sql = "SELECT * FROM " . $tabela . " WHERE " . $campo . " =:campo AND cliente = ''";
            } else if ($tabela == "comprasIt") {
                $tabela = "compras";
                $sql = "SELECT *, (select nm_nome from fornecedor where fornecedor.id_fornecedor = compras.id_fornecedor) as fornecedor, ( select sum(nf_quant * nf_preco) from itensnf where itensnf.id_compras = compras.id_compras) as valorItens FROM " . $tabela . " WHERE " . $campo . " =:campo ";
            } else if ($tabela == "faturasapg") {
                $tabela = "faturas";
                $sql = "SELECT *, (select nm_nome from fornecedor where fornecedor.id_fornecedor = faturas.id_fornecedor) as fornecedor FROM " . $tabela . " WHERE " . $campo . " =:campo ";
            } else if ($tabela == "faturaspag") {
                $tabela = "faturas";
                $sql = "SELECT *, (select nm_nome from fornecedor where fornecedor.id_fornecedor = faturas.id_fornecedor) as fornecedor FROM " . $tabela . " WHERE " . $campo . " =:campo ";
            } else if ($tabela == "faturasverNf") {
                $tabela = "compras";
                $sql = "SELECT *, (select nm_nome from fornecedor where fornecedor.id_fornecedor = $valor) as fornecedor FROM " . $tabela . " WHERE " . $campo . " =:campo ";
            } else if ($tabela == "faturasver") {
                $tabela = "faturas";
                $sql = "SELECT *, (select nm_nome from fornecedor where fornecedor.id_fornecedor = faturas.id_fornecedor) as fornecedor FROM " . $tabela . " WHERE " . $campo . " =:campo ";
            } else if ($tabela == "salarioacFh") {
                $tabela = "salario";
                $campo = "sl_vigente";
                $dataFh = $valor;
                $salac = "ac_valor";
                $saldc = "db_valor";
                $valor = "S";
                $sql = "SELECT *, (select nm_nome from funcionario where funcionario.id_funcionario = salario.id_funcionario) as nm_nome, ( select sum($salac) from salarioac where salarioac.id_funcionario = salario.id_funcionario AND ac_data_deb = " . "'$dataFh'" . ") as valorac, ( select sum($saldc) from salariodb where salariodb.id_funcionario = salario.id_funcionario AND db_data_deb = " . "'$dataFh'" . ") as valordb  FROM " . $tabela . " WHERE " . $campo . " =:campo ";
            } else if ($tabela == "salarioacFhfechadas") {
                $tabela = "salariofolhafecha";
                $campo = "data_folha";
                $dataFh = $valor;
                $salac = "ac_valor";
                $saldc = "db_valor";
                $sql = "SELECT *, (select salario from salario where salario.id_salario = salariofolhafecha.id_salario) as salario, (select nm_nome from funcionario where funcionario.id_funcionario = salariofolhafecha.id_funcionario) as nm_nome, ( select sum($salac) from salarioac where salarioac.id_funcionario = salariofolhafecha.id_funcionario AND ac_data_deb = " . "'$dataFh'" . ") as valorac, ( select sum($saldc) from salariodb where salariodb.id_funcionario = salariofolhafecha.id_funcionario AND db_data_deb = " . "'$dataFh'" . ") as valordb  FROM " . $tabela . " WHERE " . $campo . " =:campo ";
            } else if ($tabela == "salarioacFhfuncA") {
                $tabela = "salarioac";
                $campo = "id_funcionario";
                $dataFh = $valor;
                $valor = $_SESSION["idFuncFh"];
                $isLista = true;
                $sql = "SELECT * FROM " . $tabela . " WHERE ac_data_deb = " . "'$dataFh' AND " . $campo . " =:campo ";
            } else if ($tabela == "salariodeb") {
                $tabela = "salariodb";
                $salario = "db_valor";
                $datadb = $_SESSION["dataFuncFh"];
                $sql = "SELECT sum($salario) as debito FROM " . $tabela . " WHERE db_data_deb = " . "'$datadb' AND " . $campo . " =:campo ";
            } else if ($tabela == "salariocrd") {
                $tabela = "salarioac";
                $salario = "ac_valor";
                $datadb = $_SESSION["dataFuncFh"];
                $sql = "SELECT sum($salario) as credito FROM " . $tabela . " WHERE  ac_data_deb = " . "'$datadb' AND " . $campo . " =:campo ";
            } else if ($tabela == "salariodeb2") {
                $tabela = "salariodb";
                $salario = "db_valor";
                $datadb = $_SESSION["dataFuncFh"];
                $campo = "db_data_deb";
                $sql = "SELECT sum($salario) as debito FROM " . $tabela . " WHERE " . $campo . " =:campo ";
            } else if ($tabela == "salariocrd2") {
                $tabela = "salarioac";
                $salario = "ac_valor";
                $valor = $_SESSION["idFuncFh"];
                $campo = "ac_data_deb";
                $sql = "SELECT sum($salario) as credito FROM " . $tabela . " WHERE " . $campo . " =:campo ";
            } else if ($tabela == "salarioacFhfuncD") {
                $tabela = "salariodb";
                $campo = "id_funcionario";
                $dataFh = $valor;
                $valor = $_SESSION["idFuncFh"];
                $isLista = true;
                $sql = "SELECT * FROM " . $tabela . " WHERE db_data_deb = " . "'$dataFh' AND " . $campo . " =:campo ";
            } else {
                $sql = "SELECT * FROM " . $tabela . " WHERE " . $campo . " =:campo ";
            }

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":campo", $valor);
            $stmt->execute();
            if ($isLista) {
                return $stmt->fetchAll(\PDO::FETCH_OBJ);
            } else {
                return $stmt->fetch(\PDO::FETCH_OBJ);
            }
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    //Retorna uma consulta por um campo
    function findGeral($conn, $campo, $operador, $valor, $tabela = null, $isLista = false)
    {
        $tabela = ($tabela) ? $tabela : $this->tabela;
        try {
            if ($tabela == "pedidoa") {
                $tabela = "pedido";
                $sql = "SELECT * FROM " . $tabela . " WHERE " . $campo . $operador . " :campo AND encomendas = 'N' AND cliente = ''";
            } else if ($tabela == "pedidoe") {
                $tabela = "pedido";
                $sql = "SELECT * FROM " . $tabela . " WHERE " . $campo . $operador . " :campo AND encomendas = 'S' AND cliente = ''";
            } else if ($tabela == "pedidosoma") {
                $sql = "SELECT SUM(quant * valor) as soma FROM pedido WHERE nr_pedido = " . $_SESSION["nr_ped"];
            } else {
                $sql = "SELECT * FROM " . $tabela . " WHERE " . $campo . $operador . " :campo ";
            }

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":campo", $valor);
            $stmt->execute();
            if ($isLista) {
                return $stmt->fetchAll(\PDO::FETCH_OBJ);
            } else {
                return $stmt->fetch(\PDO::FETCH_OBJ);
            }
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    //Retorna uma consulta por um campo
    function findLike($conn, $campo, $valor, $tabela = null, $isLista = false, $posicao = null)
    {
        $tabela = ($tabela) ? $tabela : $this->tabela;
        try {
            if ($tabela == "comprasF") {
                $tabela = "compras";
                $sql = "SELECT *,( select nm_nome from fornecedor where fornecedor.id_fornecedor = compras.id_fornecedor ) fornecedor FROM " . $tabela . " WHERE " . $campo .  " like :campo ";
            } else {
                $sql = "SELECT * FROM " . $tabela . " WHERE " . $campo .  " like :campo ";
            }
            $stmt = $conn->prepare($sql);
            if (!$posicao) {
                $stmt->bindValue(":campo", "%" . $valor . "%");
            } else {
                if ($posicao == 1) {
                    $stmt->bindValue(":campo", $valor . "%");
                } else {
                    $stmt->bindValue(":campo", "%" . $valor);
                }
            }

            $stmt->execute();
            if ($isLista) {
                return $stmt->fetchAll(\PDO::FETCH_OBJ);
            } else {
                return $stmt->fetch(\PDO::FETCH_OBJ);
            }
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }
    function findAgrega2($conn, $tipo, $campoAgregacao, $tabela = null, $campo = null, $valor = null)
    {
        if ($tabela == "pedidos") {
            $campoAgregacao = "quant * custo";
            $tabela = "pedido";
            $campo = "nr_pedido";
            $valor = $_SESSION["nr_ped"];
        }
        if ($tabela == "caixaabre") {
            $tipo = "max";
        }

        $tabela = ($tabela) ? $tabela : $this->tabela;
        try {
            if ($campo != null && $valor != null) {
                $condicao = " WHERE " . $campo . " =:campo ";
            } else {
                $condicao = "";
            }
            if ($tipo == "soma") {
                $sql = "SELECT sum($campoAgregacao) as soma FROM " . $tabela . $condicao;
            } else if ($tipo == "total") {
                $sql = "SELECT count($campoAgregacao) as total FROM " . $tabela . $condicao;
            } else if ($tipo == "media") {
                $sql = "SELECT avg($campoAgregacao) as media FROM " . $tabela . $condicao;
            } else if ($tipo == "max") {
                $sql = "SELECT max($campoAgregacao) as max FROM " . $tabela . $condicao;
            } else if ($tipo == "min") {
                $sql = "SELECT min($campoAgregacao) as min FROM " . $tabela . $condicao;
            }
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":campo", $valor);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }
    function findAgrega($conn, $tipo, $campoAgregacao, $tabela = null, $campo = null, $valor = null)
    {

        if ($tabela == "pedidos") {
            $campoAgregacao = "quant * custo";
            $tabela = "pedido";
            $campo = "nr_pedido";
            $valor = $_SESSION["nr_ped"];
        }
        $tabela = ($tabela) ? $tabela : $this->tabela;
        try {
            if ($campo != null && $valor != null) {
                $condicao = " WHERE " . $campo . " =:campo ";
            } else {
                $condicao = "";
            }
            if ($tipo == "soma") {

                if ($tabela == "caixafechaD") {
                    $tabela = "pedido";
                    $campoAgregacao = "valor";
                    $sql = "SELECT sum($campoAgregacao) as soma FROM pedido  WHERE tipo_pg = 'Dinheiro' AND quant = '0' AND cx_fechado = 'N'";
                } else if ($tabela == "caixafechaC") {
                    $tabela = "pedido";
                    $campoAgregacao = "valor";
                    $sql = "SELECT sum($campoAgregacao) as soma FROM pedido  WHERE tipo_pg = 'Cartao' AND quant = '0' AND cx_fechado = 'N'";
                } else if ($tabela == "caixafechaP") {
                    $tabela = "pedido";
                    $campoAgregacao = "valor";
                    $sql = "SELECT sum($campoAgregacao) as soma FROM pedido  WHERE tipo_pg = 'Pix' AND quant = '0' AND cx_fechado = 'N'";
                } else if ($tabela == "caixafechaO") {
                    $tabela = "pedido";
                    $campoAgregacao = "valor";
                    $sql = "SELECT sum($campoAgregacao) as soma FROM pedido  WHERE tipo_pg = 'Outros' AND quant = '0' AND cx_fechado = 'N'";
                } else if ($tabela == "caixafechaA") {
                    $tabela = "pedido";
                    $campoAgregacao = "quant * valor";
                    $null = null;
                    $sql = "SELECT sum($campoAgregacao) as soma FROM pedido  WHERE  pago = 'N' AND cx_fechado = 'N'";
                } else if ($tabela == "pedido") {
                    $campoAgregacao = "quant * valor";
                    $sql = "SELECT sum($campoAgregacao) as soma FROM pedido  WHERE encomendas = 'N' AND nr_pedido = " . $_SESSION["nr_ped"];
                    //$sql = "SELECT sum($campoAgregacao) as soma FROM pedido  WHERE  pago = 'N' AND cx_fechado = 'N'";
                } else if ($tabela == "pedidoe") {
                    $campoAgregacao = "quant * valor";
                    $sql = "SELECT sum($campoAgregacao) as soma FROM pedido  WHERE encomendas = 'S' AND nr_pedido = " . $_SESSION["nr_ped"];
                    //$sql = "SELECT sum($campoAgregacao) as soma FROM pedido  WHERE  pago = 'N' AND cx_fechado = 'N' AND encomendas = 'S'";
                } else if ($tabela == "pedidoTotal") {
                    $tabela = "pedido";
                    $campoAgregacao = "valor";
                    $null = null;
                    $sql = "SELECT sum($campoAgregacao) as soma FROM pedido  WHERE  quant = '0' AND pago = 'S' AND cx_fechado = 'S'";
                } else if ($tabela == "salarioTotal") {
                    $tabela = "salariofolha";
                    $campoAgregacao = "salario_ac + salario_db + salario_pg";
                    $null = null;
                    $sql = "SELECT sum($campoAgregacao) as soma FROM salariofolha";
                } else if ($tabela == "pedidoTotalData") {
                    $tabela = "pedido";
                    $campoAgregacao = "valor";
                    $null = null;
                    $dataIn = $_SESSION["dataIn"];
                    $dataFim = $_SESSION["dataFim"];
                    $sql = "SELECT sum($campoAgregacao) as soma FROM pedido  WHERE  quant = '0' AND pago = 'S' AND cx_fechado = 'S' AND data_fch_pedido between '$dataIn' AND '$dataFim'";
                } else if ($tabela == "salarioTotalData") {
                    $tabela = "salariofolha";
                    $campoAgregacao = "salario_ac + salario_db + salario_pg";
                    $null = null;
                    $dataIn = $_SESSION["dataIn"];
                    $dataFim = $_SESSION["dataFim"];
                    $sql = "SELECT sum($campoAgregacao) as soma FROM salariofolha  WHERE   cad_dat between '$dataIn' AND '$dataFim'";
                } else if ($tabela == "pedidoAreceber") {
                    $tabela = "pedido";
                    $campoAgregacao = "quant * valor";
                    $sql = "SELECT sum($campoAgregacao) as soma FROM pedido  WHERE  pago = 'N' AND cx_fechado = 'N'";
                } else if ($tabela == "pedidoAreceberCli") {
                    $tabela = "pedido";
                    $campoAgregacao = "quant * valor";
                    $sql = "SELECT sum($campoAgregacao) as soma FROM pedido  WHERE  nr_pedido = '$valor'";
                } else if ($tabela == "custoAreceber") {
                    $tabela = "pedido";
                    $campoAgregacao = "quant * custo";
                    $sql = "SELECT sum($campoAgregacao) as soma FROM pedido  WHERE  pago = 'N' AND cx_fechado = 'N'";
                } else if ($tabela == "custoAreceberCli") { ///aqui
                    $tabela = "pedido";
                    $campoAgregacao = "quant * custo";
                    $sql = "SELECT sum($campoAgregacao) as soma FROM pedido  WHERE  nr_pedido = '$valor'";
                } else if ($tabela == "comprasTotal") {
                    $tabela = "compras";
                    $campoAgregacao = "valor_nf";
                    $null = null;
                    $sql = "SELECT sum($campoAgregacao) as soma FROM compras WHERE  id_compras > '0'";
                } else if ($tabela == "comprasTotalData") {
                    $tabela = "compras";
                    $campoAgregacao = "valor_nf";
                    $null = null;
                    $dataIn = $_SESSION["dataIn"];
                    $dataFim = $_SESSION["dataFim"];
                    $sql = "SELECT sum($campoAgregacao) as soma FROM compras WHERE  data_nf between '$dataIn' AND '$dataFim'";
                } else if ($tabela == "despesasTotal") {
                    $tabela = "itensnf";
                    $campoAgregacao = "nf_preco";
                    $null = null;
                    $sql = "SELECT sum($campoAgregacao) as soma FROM itensnf WHERE  nf_tipo =  'despesas'";
                } else if ($tabela == "despesasTotalData") {
                    $tabela = "itensnf";
                    $campoAgregacao = "nf_preco";
                    $null = null;
                    $dataIn = $_SESSION["dataIn"];
                    $dataFim = $_SESSION["dataFim"];
                    $sql = "SELECT sum($campoAgregacao) as soma FROM itensnf WHERE  nf_tipo =  'despesas' AND data_nf between '$dataIn' AND '$dataFim'";
                } else if ($tabela == "producaoTotal") {
                    $tabela = "itensnf";
                    $campoAgregacao = "nf_preco";
                    $null = null;
                    $sql = "SELECT sum($campoAgregacao) as soma FROM itensnf WHERE  nf_tipo =  'producao'";
                } else if ($tabela == "producaoTotalData") {
                    $tabela = "itensnf";
                    $campoAgregacao = "nf_preco";
                    $null = null;
                    $dataIn = $_SESSION["dataIn"];
                    $dataFim = $_SESSION["dataFim"];
                    $sql = "SELECT sum($campoAgregacao) as soma FROM itensnf WHERE  nf_tipo =  'producao' AND data_nf between '$dataIn' AND '$dataFim'";
                } else if ($tabela == "terceirosTotal") {
                    $tabela = "itensnf";
                    $campoAgregacao = "nf_preco";
                    $null = null;
                    $sql = "SELECT sum($campoAgregacao) as soma FROM itensnf WHERE  nf_tipo =  'compras'";
                } else if ($tabela == "terceirosTotalData") {
                    $tabela = "itensnf";
                    $campoAgregacao = "nf_preco";
                    $null = null;
                    $dataIn = $_SESSION["dataIn"];
                    $dataFim = $_SESSION["dataFim"];
                    $sql = "SELECT sum($campoAgregacao) as soma FROM itensnf WHERE  nf_tipo =  'compras' AND data_nf between '$dataIn' AND '$dataFim'";
                } else if ($tabela == "faturasapg") {
                    $tabela = "faturas";
                    $campoAgregacao = "ft_valor";
                    $null = null;
                    $sql = "SELECT sum($campoAgregacao) as soma FROM faturas  WHERE   ft_paga = 'N'";
                } else if ($tabela == "faturaspag") {
                    $tabela = "faturas";
                    $campoAgregacao = "ft_valor_pg";
                    $null = null;
                    $sql = "SELECT sum($campoAgregacao) as soma FROM faturas  WHERE   ft_paga = 'S'";
                } else if ($tabela == "pedidoTotal2") {
                    $tabela = "pedido";
                    $campoAgregacao = "valor";
                    $null = null;
                    $dataIn = $_SESSION["dataIn"];
                    $dataFim = $_SESSION["dataFim"];
                    $sql = "SELECT sum($campoAgregacao) as soma FROM pedido  WHERE  quant = '0' AND pago = 'S' AND cx_fechado = 'S' AND data_fch_pedido between '$dataIn' AND '$dataFim'";
                } else if ($tabela == "apagarDatas") {
                    $tabela = "faturas";
                    $campoAgregacao = "ft_valor";
                    $null = null;
                    $dataIn = $_SESSION["dataIn"];
                    $dataFim = $_SESSION["dataFim"];
                    $sql = "SELECT sum($campoAgregacao) as soma FROM faturas  WHERE ft_paga = 'N'  AND ft_venc between '$dataIn' AND '$dataFim'";
                } else if ($tabela == "apagarDatas3") {
                    $tabela = "faturas";
                    $campoAgregacao = "ft_valor_pg";
                    $null = null;
                    $dataIn = $_SESSION["dataIn"];
                    $dataFim = $_SESSION["dataFim"];
                    $sql = "SELECT sum($campoAgregacao) as soma FROM faturas  WHERE ft_paga = 'S'  AND ft_venc between '$dataIn' AND '$dataFim'";
                } else if ($tabela == "apagarDatas2") {
                    $tabela = "faturas";
                    $campoAgregacao = "ft_valor";
                    $null = null;
                    $dataIn = $_SESSION["dataIn"];
                    $dataFim = $_SESSION["dataFim"];
                    $sql = "SELECT FROM faturas  WHERE ft_paga = 'N'  AND ft_venc between '$dataIn' AND '$dataFim'";
                } else if ($tabela == "custoTotal") {
                    $tabela = "pedido";
                    $campoAgregacao = "custo";
                    $null = null;
                    $sql = "SELECT sum($campoAgregacao) as soma FROM pedido  WHERE  quant = '0' AND pago = 'S' AND cx_fechado = 'S'";
                } else if ($tabela == "custoTotal2") {
                    $tabela = "pedido";
                    $campoAgregacao = "custo";
                    $null = null;
                    $dataIn = $_SESSION["dataIn"];
                    $dataFim = $_SESSION["dataFim"];
                    $sql = "SELECT sum($campoAgregacao) as soma FROM pedido  WHERE  quant = '0' AND pago = 'S' AND cx_fechado = 'S' AND data_fch_pedido between '$dataIn' AND '$dataFim'";
                } else {
                    $sql = "SELECT sum($campoAgregacao) as soma FROM " . $tabela . $condicao;
                }
            } else if ($tipo == "total") {
                $sql = "SELECT count($campoAgregacao) as total FROM " . $tabela . $condicao;
            } else if ($tipo == "media") {
                $sql = "SELECT avg($campoAgregacao) as media FROM " . $tabela . $condicao;
            } else if ($tipo == "max") {
                $sql = "SELECT max($campoAgregacao) as max FROM " . $tabela . $condicao;
            } else if ($tipo == "min") {
                $sql = "SELECT min($campoAgregacao) as min FROM " . $tabela . $condicao;
            }
            $stmt = $conn->prepare($sql);
            //$stmt->bindValue(":campo", $valor);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }
    //Retorna uma consulta por um campo
    function findEntre($conn, $campo, $valor1, $valor2, $tabela = null)
    {
        $tabela = ($tabela) ? $tabela : $this->tabela;
        try {
            $sql = "SELECT * FROM " . $tabela . " WHERE " . $campo . " between  :valor1 AND :valor2 ";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":valor1", $valor1);
            $stmt->bindValue(":valor2", $valor2);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    function add($conn, $dados, $tabela = null)
    {
        $tabela = ($tabela) ? $tabela : $this->tabela;
        if (!$dados) {
            throw new Exception("É necessário enviar os parâmetros para o método add");
        }

        if (!is_array($dados)) {
            throw new Exception("Para poder inserir os dados os valores precisam está em forma de array");
        }
        try {
            $campos     = implode(", ", array_keys($dados));
            $valores     = ":" . implode(", :", array_keys($dados));
            $sql = "INSERT INTO {$tabela} ({$campos}) VALUES ({$valores}) ";
            $stmt = $conn->prepare($sql);
            foreach ($dados as $chave => $valor) {
                $stmt->bindValue(":$chave", $valor);
            }
            if ($stmt->execute()) {
                return $conn->lastInsertId();
            }
            return false;
        } catch (Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    function edit($conn, $dados, $campo, $tabela = null)
    {
        $tabela = ($tabela) ? $tabela : $this->tabela;
        $parametro = null;

        if (!$dados) {
            throw new Exception("É necessário enviar os parâmetros para o método edit");
        }

        if (!is_array($dados)) {
            throw new Exception("Para poder editar os dados os valores precisam está em forma de array");
        }

        try {
            foreach ($dados as $chave => $valor) {
                $parametro .= "$chave=:$chave, ";
            }
            $condicao = $campo . " = " . $dados[$campo];
            $parametro = rtrim($parametro, ', ');

            $sql = "UPDATE {$tabela} SET {$parametro} WHERE {$condicao} ";
            $stmt = $conn->prepare($sql);
            foreach ($dados as $chave => $valor) {
                $stmt->bindValue(":$chave", $valor);
            }
            $stmt->execute();
            return $stmt->rowCount();
        } catch (Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    function del($conn, $campo, $valor, $tabela = null)
    {
        $tabela = ($tabela) ? $tabela : $this->tabela;

        if (!$campo || !$valor) {
            throw new Exception("É necessário enviar o campo e o valor para fazer a exclusão");
        }
        try {
            $sql  = "DELETE FROM {$tabela} WHERE {$campo} = :valor";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":valor", $valor);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    function del2($conn, $campo, $valor, $valor2 = null, $tabela = null)
    {
        $tabela = ($tabela) ? $tabela : $this->tabela;

        if (!$campo || !$valor) {
            throw new Exception("É necessário enviar o campo e o valor para fazer a exclusão");
        }
        try {
            $sql  = "DELETE FROM {$tabela} WHERE {$campo} = :valor";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":valor", $valor);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}