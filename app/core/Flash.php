<?php

namespace app\core;

use PDO;
use PDOException;

class Flash
{

    // Função para obter os itens de um pedido específico
    public static function getItensPorPedido($db, $nr_pedido)
    {
        $sql = "SELECT * FROM pedido WHERE nr_pedido = :nr_pedido";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':nr_pedido', $nr_pedido, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC); // Retorna os itens do pedido
    }

    // Criar cliente asaas
    public static function novoCliAsass($cliente)
    {
        // URL da API para criar o cliente
        $url = 'https://www.asaas.com/api/v3/customers';

        // Token de autenticação (substitua com o seu token Asaas)
        $token = '$aact_YTU5YTE0M2M2N2I4MTliNzk0YTI5N2U5MzdjNWZmNDQ6OjAwMDAwMDAwMDAwMDAwOTAwNzY6OiRhYWNoXzRjM2Y0ODU2LWJlOWQtNGE1Yi05NTUyLTdhYmI4ZWQzNTc3OQ==';

        // Objeto stdClass

        // Dados do cliente formatados para a API do Asaas
        $data_cliente_asaas = array(
            'name' => $cliente->nm_nome, // Nome completo
            'email' => $cliente->e_mail, // E-mail
            'cpfCnpj' => preg_replace('/[^0-9]/', '', $cliente->nr_cpf_cnpj), // CPF ou CNPJ (apenas números)
            'phone' => substr(preg_replace('/[^0-9]/', '', $cliente->nr_fone), 0, 10), // Telefone fixo (apenas números)
            'mobilePhone' => preg_replace('/[^0-9]/', '', $cliente->nr_fone), // Celular (apenas números)
            'postalCode' => preg_replace('/[^0-9]/', '', $cliente->nr_cep), // CEP (apenas números)
            'address' => $cliente->nm_rua, // Endereço
            'addressNumber' => $cliente->nr_numero, // Número do endereço
            'complement' => '', // Complemento (opcional)
            'province' => $cliente->nm_bairro, // Bairro
            'city' => $cliente->nm_cidade, // Cidade
            'state' => $cliente->sg_estado, // Estado (sigla de 2 caracteres)
        );

        // Converter os dados do cliente para JSON
        $data_cliente_json = json_encode($data_cliente_asaas);

        // Configurar os cabeçalhos da requisição
        $headers = array(
            'Content-Type: application/json',
            'access_token: ' . trim($token), // Seu token do Asaas
            'User-Agent: MinhaAplicacao/1.0',
        );

        // Inicializar cURL
        $ch = curl_init('https://www.asaas.com/api/v3/customers');

        // Definir as opções da requisição cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_cliente_json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Executar a requisição e obter a resposta
        $response = curl_exec($ch);

        // Verificar o código HTTP da resposta
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($http_code == 200) {
            // Cliente criado com sucesso
            $resposta_cliente = json_decode($response, true);
            $customer_id = $resposta_cliente['id']; // Capturar o ID do cliente recém-criado
            echo 'Cliente criado com sucesso. ID: ' . $customer_id;
        } else {
            // Exibir qualquer erro retornado pela API do Asaas
            echo 'Erro HTTP: ' . $http_code . '<br>';
            echo 'Resposta: ' . $response . '<br>';
        }

        // Fechar o cURL
        curl_close($ch);
    }
    //Api asaas
    public  static function apiasaas()
    {
        // Habilitar exibição de erros no PHP
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);


        // Definir a URL da API
        $url = 'https://sandbox.asaas.com/api/v3/payments';

        // Configurar o token de autenticação (substitua com o seu token Asaas)
        $token = '$aact_YTU5YTE0M2M2N2I4MTliNzk0YTI5N2U5MzdjNWZmNDQ6OjAwMDAwMDAwMDAwMDAwOTAwNzY6OiRhYWNoXzRjM2Y0ODU2LWJlOWQtNGE1Yi05NTUyLTdhYmI4ZWQzNTc3OQ==';

        // Dados da cobrança
        $data = array(
            'customer' => 'edd7775d-08b7-4f42-9435-e0f7a893dae8', // Certifique-se de que o ID do cliente está correto
            'billingType' => 'PIX',
            'dueDate' => '2024-09-23',
            'value' => 150.00,
            'description' => 'Descrição do pagamento',
        );

        // Converter o array de dados para JSON
        $data_json = json_encode($data);

        // Configurar os cabeçalhos da requisição, incluindo o User-Agent
        $headers = array(
            'Content-Type: application/json',
            'access_token: ' . $token,
            'User-Agent: MinhaAplicacao/1.0', // Você pode personalizar o valor do User-Agent
        );

        // Inicializar cURL
        $ch = curl_init($url);

        // Definir as opções da requisição cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Timeout de 10 segundos

        // Executar a requisição e obter a resposta
        $response = curl_exec($ch);

        // Verificar se houve erro no cURL
        if (curl_errno($ch)) {
            echo 'Erro no cURL: ' . curl_error($ch);
        } else {
            // Verificar o código HTTP da resposta
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            // Exibir o código HTTP e a resposta bruta
            echo 'Código HTTP: ' . $http_code . '<br>';
            echo 'Resposta bruta: ' . $response . '<br>';
        }

        // Fechar o cURL
        curl_close($ch);
    }
    //Atualizar saldo corrente
    public static function debitoAl($db, $id_user, $id_corretora, $nr_doc_banco, $cod_despesa, $data_cad, $descricao, $nr_doc_pg, $valor_credito, $valor_debito, $data_confirma, $confirma, $obs, $tipo)
    {
        try {
            $sql = "INSERT INTO corrente (id_user, id_corretora, nr_doc_banco, cod_despesa, data_cad, descricao, nr_doc_pg, valor_credito, valor_debito, data_confirma, confirma, obs, tipo)
             VALUES (:id_user, :id_corretora, :nr_doc_banco, :cod_despesa, :data_cad, :descricao, :nr_doc_pg, :valor_credito, :valor_debito, :data_confirma, :confirma, :obs, :tipo)";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id_user', $id_user);
            $stmt->bindValue(':id_corretora', $id_corretora);
            $stmt->bindValue(':nr_doc_banco', $nr_doc_banco);
            $stmt->bindValue(':cod_despesa', $cod_despesa);
            $stmt->bindValue(':data_cad', $data_cad);
            $stmt->bindValue(':descricao', $descricao);
            $stmt->bindValue(':nr_doc_pg', $nr_doc_pg);
            $stmt->bindValue(':valor_credito', $valor_credito);
            $stmt->bindValue(':valor_debito', $valor_debito);
            $stmt->bindValue(':data_confirma', $data_confirma);
            $stmt->bindValue(':confirma', $confirma);
            $stmt->bindValue(':obs', $obs);
            $stmt->bindValue(':tipo', $tipo);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
        return false;
    }
    //Saldo cantina
    public static function saldoCantina($pdo, $cod_despesa)
    {
        try {
            // Preparar a query SQL
            $stmt = $pdo->prepare("SELECT (SUM(valor_credito) - SUM(valor_debito)) AS saldo FROM corrente WHERE cod_despesa = :cod_despesa AND confirma = :confirma");

            // Executar a consulta passando o parâmetro
            $stmt->execute([
                'confirma' => "S",
                'cod_despesa' => $cod_despesa
            ]);

            // Obter o resultado
            $saldo = $stmt->fetch(PDO::FETCH_ASSOC);

            // Retornar o saldo
            return $saldo['saldo'];
        } catch (PDOException $e) {
            return "Erro: " . $e->getMessage();
        }
    }
    public static function compromissos($pdo)
    {
        try {
            // Preparar a query SQL
            $stmt = $pdo->prepare("SELECT * FROM compromisso WHERE nr_pedido = 0");

            // Executar a consulta passando o parâmetro
            $stmt->execute([]);

            // Retornar os resultados
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return "Erro: " . $e->getMessage();
        }
    }
    public static function compromissosDia($pdo)
    {
        try {
            // Preparar a query SQL
            $stmt = $pdo->prepare("SELECT * FROM compromisso WHERE nr_pedido > 0 AND data_comp = :data_comp AND data_entrega IS NULL");

            // Executar a consulta passando o parâmetro
            $stmt->execute([
                'data_comp' => date('Y-m-d')  // Data de hoje no formato adequado
            ]);

            // Retornar os resultados
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return "Erro: " . $e->getMessage();
        }
    }
    public static function confEnt($pdo, $id_compromisso)
    {
        try {
            // Preparar a query SQL            
            $stmt = $pdo->prepare("UPDATE compromisso SET data_entrega = :data_entrega WHERE id_compromisso  = :id_compromisso ");
            $stmt->execute([
                'data_entrega' => dateTime(date('Y-m-d')),
                'id_compromisso' => $id_compromisso
            ]);
        } catch (PDOException $e) {
            return "Erro: " . $e->getMessage();
        }
    }
    public static function totalPedido($pdo, $nr_pedido)
    {
        try {
            // Preparar a query SQL
            $stmt = $pdo->prepare("SELECT (SUM(valor)) AS totalPedido FROM pedido WHERE nr_pedido = :nr_pedido");

            // Executar a consulta passando o parâmetro
            $stmt->execute([
                'nr_pedido' => $nr_pedido
            ]);

            // Obter o resultado
            $saldo = $stmt->fetch(PDO::FETCH_ASSOC);

            // Retornar o saldo
            return $saldo['totalPedido'];
        } catch (PDOException $e) {
            return "Erro: " . $e->getMessage();
        }
    }

    //Contador de visitas
    public static function contador($db)
    {
        $current_date = date('Y-m-d');
        $user_ip = $_SERVER['REMOTE_ADDR'];

        try {
            $sql = "SELECT COUNT(*) AS totalv FROM visitas";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetch();
            $total_visitas = $row['totalv'];

            $sql = "SELECT COUNT(id_visita) AS total FROM visitas WHERE data_visita = '$current_date' AND id_visita = '$user_ip'";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetch();
            $total_visita = $row['total'];
            $num_rows = $total_visita;
            if ($num_rows == 0) {
                // Inserir um novo registro
                $sql = "INSERT INTO visitas (id_visita, data_visita) VALUES (:valor1, :valor2)";
                $sql = $db->prepare($sql);
                $sql->bindParam(':valor1', $user_ip);
                $sql->bindParam(':valor2', $current_date);
                $sql->execute();
                // Executar a inserção
                $sql = "SELECT COUNT(*) AS totalv FROM visitas";
                $stmt = $db->prepare($sql);
                $stmt->execute();
                $row = $stmt->fetch();
                $total_visitas = $total_visitas;
                return $total_visitas;
            } else {
            }
            return $total_visitas;
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }
    public static function clientes($db)
    {
        $isLista = true;
        $sql = "SELECT nm_nome FROM cliente";
        $sql = $db->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(\PDO::FETCH_OBJ);
    }
    public static function cliente($db)
    {
        $isLista = false;
        $sql = "SELECT * FROM cliente Where id_cliente =:id_cliente";
        $sql = $db->prepare($sql);
        $sql->bindValue(':id_cliente', $_SESSION[SESSION_LOGIN]->id_user);
        $sql->execute();
        return $sql->fetchAll(\PDO::FETCH_OBJ);
    }
    public static function tokenValido($pdo, $token)
    {
        try {
            // Preparar a query SQL
            $stmt = $pdo->prepare("SELECT id_user, token FROM user WHERE token = :token AND expira > NOW()");
            $stmt->execute(['token' => $token]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            return "Erro: " . $e->getMessage();
        }
    }
    public static function novaSenha($pdo, $novaSenha, $id_user)
    {
        try {
            // Preparar a query SQL            
            $stmt = $pdo->prepare("UPDATE user SET senha = :senha, token = :token, expira = :expira WHERE id_user  = :id_user ");
            $stmt->execute([
                'senha' => $novaSenha,
                'token' => "",
                'expira' => "",
                'id_user' => $id_user
            ]);
        } catch (PDOException $e) {
            return "Erro: " . $e->getMessage();
        }
    }

    public static function balancoData($db)
    {
        $tabela = "compras";
        try {
            $sql = "SELECT DISTINCT month(data_nf) as mes, year(data_nf) as ano FROM " . $tabela;
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }
    public static function faturaCad($db, $id_compras, $id_fornecedor, $ft_valor, $ft_venc, $ft_nr, $ft_paga, $ft_data_pg, $ft_valor_pg, $ft_doc)
    {
        try {


            $sql = "INSERT INTO faturas (id_compras, id_fornecedor, ft_valor, ft_venc, ft_nr, ft_paga, ft_data_pg, ft_valor_pg, ft_doc) VALUES (:id_compras, :id_fornecedor, :ft_valor, :ft_venc, :ft_nr, :ft_paga, :ft_data_pg, :ft_valor_pg, :ft_doc)";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id_compras', $id_compras);
            $stmt->bindValue(':id_fornecedor', $id_fornecedor);
            $stmt->bindValue(':ft_valor', $ft_valor);
            $stmt->bindValue(':ft_venc', $ft_venc);
            $stmt->bindValue(':ft_nr', $ft_nr);
            $stmt->bindValue(':ft_paga', $ft_paga);
            $stmt->bindValue(':ft_data_pg', $ft_data_pg);
            $stmt->bindValue(':ft_valor_pg', $ft_valor_pg);
            $stmt->bindValue(':ft_doc', $ft_doc);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
        return false;
    }
    public static function itensCompras($db, $id_fornecedor, $id_compras, $nf_nome, $nf_tipo, $nf_preco, $data_nf)
    {
        try {

            $nf_quant = 1;
            $nf_desc = 0;
            $sql = "INSERT INTO itensnf (id_fornecedor, id_compras, nf_nome, nf_tipo, nf_preco, data_nf) VALUES (:id_fornecedor, :id_compras, :nf_nome, :nf_tipo, :nf_preco, :data_nf)";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id_fornecedor', $id_fornecedor);
            $stmt->bindValue(':id_compras', $id_compras);
            $stmt->bindValue(':nf_nome', $nf_nome);
            $stmt->bindValue(':nf_tipo', $nf_tipo);
            $stmt->bindValue(':nf_preco', $nf_preco);
            $stmt->bindValue(':data_nf', $data_nf);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
        return false;
    }
    public static function contarReg($db, $d1, $d2)
    {

        try {
            $sql = "SELECT max(nr_nf) as contado FROM compras WHERE data_nf BETWEEN '$d1' AND '$d2'";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }
    public static function produzirTot($db)
    {
        $tabela = "pedido";
        try {
            $sql = "SELECT sum(quant * valor) as soma FROM " . $tabela . " WHERE  pago = 'N' AND cliente = '' AND encomendas = 'S'";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public static function produzir($db, $id)
    {
        $tabela = "pedido";
        try {
            $sql = "SELECT sum(quant * valor) as soma FROM " . $tabela . " WHERE data_encomendas = '$id'  AND pago = 'N' AND cliente = ''";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public static function produzirQuant($db, $id, $nome)
    {

        $tabela = "pedido";
        try {
            $sql = "SELECT sum(quant) as soma FROM " . $tabela . " WHERE data_encomendas = '$id' AND nome = '$nome'  AND pago = 'N' AND cliente = ''";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public static function produzirItens($db, $id, $nome)
    {

        $tabela = "pedido";
        try {
            $sql = "SELECT sum(quant) as soma FROM " . $tabela . " WHERE data_ab_pedido = '$id' AND nome = '$nome'  AND pago = 'S' AND cliente = ''";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public static function produzirNome($db, $id)
    {
        $tabela = "pedido";
        $nome = "Bolo";
        try {
            $sql = "SELECT DISTINCT nome FROM " . $tabela . " WHERE data_encomendas = '$id' AND pago = 'N' AND cliente = ''";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public static function produzirItem($db, $id)
    {
        $tabela = "pedido";
        try {
            $sql = "SELECT DISTINCT nome FROM " . $tabela . " WHERE data_ab_pedido = '$id' AND cliente = ''";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public static function producao($db, $data_encomendas)
    {
        $isLista = true;
        $sql = "SELECT * FROM pedido WHERE cliente = '' AND pago = 'N' AND  data_encomendas = '$data_encomendas'";
        $sql = $db->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(\PDO::FETCH_OBJ);
    }
    public static function produtosPrato($pdo)
    {
        try {

            // Definir o valor do campo
            $categoria = 'prato';

            // Preparar a query SQL
            $stmt = $pdo->prepare("SELECT * FROM produtos WHERE categorias <> :categorias");

            // Associar o valor do campo ao parâmetro
            $stmt->bindParam(':categorias', $categoria, PDO::PARAM_STR);

            // Executar a query
            $stmt->execute();

            // Obter os resultados
            return $resultados = $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return "Erro: " . $e->getMessage();
        }
    }
    public static function fechafhFuncSalarios($db, $datafh, $id_funcionario, $id_salario)
    {
        try {
            $sql = "INSERT INTO salariofolhafecha (data_folha, id_funcionario, id_salario) VALUES (:data_folha, :id_funcionario, :id_salario)";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':data_folha', $datafh);
            $stmt->bindValue(':id_funcionario', $id_funcionario);
            $stmt->bindValue(':id_salario', $id_salario);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
        return false;
    }
    public static function fechafhFunc($db, $salario_ac, $salario_db, $salario_pg, $id)
    {
        $folha_ab = "N";
        try {
            $sql = "UPDATE salariofolha SET salario_ac =:salario_ac, salario_db =:salario_db, salario_pg =:salario_pg, folha_ab =:folha_ab  WHERE id_salariofolha =:id_salariofolha";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':salario_ac', $salario_ac);
            $stmt->bindValue(':salario_db', $salario_db);
            $stmt->bindValue(':salario_pg', $salario_pg);
            $stmt->bindValue(':folha_ab', $folha_ab);
            $stmt->bindValue(':id_salariofolha', $id);
            $stmt->execute();
            if ($salario_ac > 0) {
                $datasc = "'" . $_SESSION["idFuncFh"] . "'";
                $sql = "UPDATE salarioac SET folha_ab = 'N' WHERE ac_data_deb = " .  $datasc;
                $stmt = $db->prepare($sql);
                $stmt->execute();
            }
            if ($salario_db > 0) {
                $datasc = "'" . $_SESSION["idFuncFh"] . "'";
                $sql = "UPDATE salariodb SET folha_ab = 'N' WHERE db_data_deb = " . $datasc;
                $stmt = $db->prepare($sql);
                $stmt->execute();
            }
            return $stmt->rowCount();
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
        return false;
    }

    //Tuta $sql->bindValue(':valor_cotacao', $valor_cotacao);
    public static function novoSalario($db, $id)
    {
        $dataFim = dateTime();
        try {
            $sql = "UPDATE salario SET sl_vigente = 'N', dat_fim =:dat_fim WHERE id_salario = " . $id;
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':dat_fim', $dataFim);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
        return false;
    }
    public static function salvaEncomendas($db, $id_user, $nr_pedido, $descricao, $data_comp)
    {
        try {
            $sql = "INSERT INTO compromisso (id_user, nr_pedido, descricao, data_comp) VALUES (:id_user, :nr_pedido, :descricao, :data_comp)";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id_user', $id_user);
            $stmt->bindValue(':nr_pedido', $nr_pedido);
            $stmt->bindValue(':descricao', $descricao);
            $stmt->bindValue(':data_comp', $data_comp);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
        return false;
    }

    public static function novoPedido($db, $nrPedido)
    {
        try {
            $sql = "INSERT INTO nr_pedido (nr_cli) VALUES (:nr_cli)";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':nr_cli', $nrPedido);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
        return false;
    }

    public static function estornadDp($db, $id)

    {
        $ft_valor_pg = null;
        $ft_data_pg = null;
        try {
            $sql = "UPDATE faturas SET FT_paga = 'N', ft_data_pg = null, ft_valor_pg = null WHERE id_faturas = " . $id;
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
        return false;
    }

    public static function fechaCx($db)
    {
        try {
            $sql = "UPDATE pedido SET pago = 'S' WHERE nr_pedido = " . $_SESSION["nr_ped"];
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
        return false;
    }
    public static function maximo($db, $tabela, $campo, $condicao)
    {
        try {
            $sql = "SELECT MAX(id_caixaabre) AS maximo FROM " . $tabela . "  WHERE " . $campo . "=:fechado";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(":fechado", $condicao);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $stmt = $stmt->fetch();
                return $stmt['maximo'];
            }
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
        return false;
    }
    public static function maximo3($db, $tabela, $campo)
    {
        try {
            $sql = "SELECT MAX($campo) AS maximo FROM " . $tabela;
            $stmt = $db->prepare($sql);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $stmt = $stmt->fetch();
                return $stmt['maximo'];
            }
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
        return false;
    }
    public static function soma($db, $tabela, $condicao, $campo, $valor)
    {

        try {
            $sql = "SELECT SUM($condicao) AS soma FROM " . $tabela . "  WHERE " . $campo . "=:id";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(":id", $valor);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $stmt = $stmt->fetch();
                return $stmt['soma'];
            }
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
        return false;
    }
    public static function caixaFecha($db, $id)
    {
        try {
            $sql = "UPDATE caixaabre SET fechado = 'S' WHERE id_caixaabre =" . $id;
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
        return false;
    }
    public static function fechaItens($db, $dt)
    {
        try {
            $sql = "UPDATE pedido SET cx_fechado = 'S' WHERE pago = 'S'";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
        return false;
    }
    public static function maximo2($db, $tabela, $campo, $condicao)
    {
        try {
            $sql = "SELECT MAX(id_caixaabre) AS maximo FROM " . $tabela . "  WHERE " . $campo . "=:fechado";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(":fechado", $condicao);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $stmt = $stmt->fetch();
                return $stmt['maximo'];
            }
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
        return false;
    }
    public static function setMsg($msg, $tipo = 1)
    {
        //1 - sucesso / -1 erro / 2 info
        $classe = "sucesso";
        $icone  = "fa-check";
        if ($tipo == -1) {
            $classe = "erro";
            $icone  = "fa-exclamation-triangle";
        } else if ($tipo == 2) {
            $classe = "info";
            $icone  = "fa-exclamation-circle";
        }

        $resultado = (object) array(
            "tipo" => $tipo,
            "msg"  => $msg,
            "classe" => $classe,
            "icone" => $icone
        );

        $_SESSION["msg"] = $resultado;
    }

    public static function getMsg()
    {
        $msg = (isset($_SESSION["msg"])) ? $_SESSION["msg"] : null;
        if ($msg) {
            unset($_SESSION["msg"]);
        }
        return $msg;
    }

    public static function limpaMsg()
    {
        unset($_SESSION["msg"]);
    }

    public static function isMsg()
    {
        return (isset($_SESSION["msg"])) ? true : false;
    }

    //Erros
    public static function setErro(array $erros)
    {
        $_SESSION["erro"] = $erros;
    }

    public static function getErro()
    {
        $erro = (isset($_SESSION["erro"])) ? $_SESSION["erro"] : null;
        if ($erro) {
            unset($_SESSION["erro"]);
        }
        return $erro;
    }

    public static function limpaErro()
    {
        unset($_SESSION["erro"]);
    }

    public static function isErro()
    {
        return (isset($_SESSION["erro"])) ? true : false;
    }


    //Formulário
    public static function setForm($form)
    {
        $_SESSION["form"] = $form;
    }

    public static function getForm()
    {
        $form = (isset($_SESSION["form"])) ? $_SESSION["form"] : null;
        if ($form) {
            unset($_SESSION["form"]);
        }
        return $form;
    }

    public static function limpaForm()
    {
        unset($_SESSION["form"]);
    }

    public static function isForm()
    {
        return (isset($_SESSION["form"])) ? true : false;
    }
}
