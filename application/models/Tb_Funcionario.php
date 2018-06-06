<?php
class tb_funcionario extends CI_Model {

  public function getHtmlList(){
    $this->load->database();
    $htmlTable  = "";
    $htmlTable .= "<table class='table table-bordered dynatable' id='tbProdutoGetHtmlList'>";
    $htmlTable .= "  <thead>";
    $htmlTable .= "    <tr>";
    $htmlTable .= "      <th width='8%'>ID</th>";
    $htmlTable .= "      <th>Nome</th>";
    $htmlTable .= "      <th width='10%'>CPF</th>";
    $htmlTable .= "      <th width='12%'>Telefone</th>";
    $htmlTable .= "      <th>Cidade</th>";
    $htmlTable .= "      <th width='8%'>Ver</th>";
    $htmlTable .= "      <th width='8%'>Editar</th>";
    $htmlTable .= "      <th width='8%'>Deletar</th>";
    $htmlTable .= "    </tr>";
    $htmlTable .= "  </thead>";
    $htmlTable .= "  <tbody>";

    $vSql  = " SELECT fun_id, fun_nome, fun_cpf_cnpj, fun_tel_ddd, fun_tel_numero, fun_end_cidade, fun_end_estado ";
    $vSql .= " FROM tb_funcionario ";
    $vSql .= " WHERE fun_ativo = true ";
    $vSql .= " ORDER BY fun_nome ";

    $query = $this->db->query($vSql);
    $arrRs = $query->result_array();

    if(count($arrRs) <= 0){
      /*$htmlTable .= "  <tr class=''>";
      $htmlTable .= "    <td colspan='8'>";
      $htmlTable .= "      <center>Nenhum resultado encontrado!</center>";
      $htmlTable .= "    </td>";
      $htmlTable .= "  </tr>";*/
    } else {
      foreach($arrRs as $rs1){
        $vFunId        = $rs1["fun_id"];
        $vFunNome      = $rs1["fun_nome"];
        $vFunCpfCnpj   = $rs1["fun_cpf_cnpj"];
        $vFunTelefone  = "(".$rs1["fun_tel_ddd"].") " . $rs1["fun_tel_numero"];
        $vFunCidade    = $rs1["fun_end_cidade"] . " (".$rs1["fun_end_estado"].")";

        $htmlTable .= "<tr>";
        $htmlTable .= "  <td>$vFunId</td>";
        $htmlTable .= "  <td>$vFunNome</td>";
        $htmlTable .= "  <td>$vFunCpfCnpj</td>";
        $htmlTable .= "  <td>$vFunTelefone</td>";
        $htmlTable .= "  <td>$vFunCidade</td>";
        $htmlTable .= "  <td><a href='javascript:;' class='dynatableLink' data-url='".base_url() . "Funcionario/ver/$vFunId" . "'><i class='icon-eye-open icon-lista'></i></a></td>";
        $htmlTable .= "  <td><a href='javascript:;' class='dynatableLink' data-url='".base_url() . "Funcionario/editar/$vFunId" . "'><i class='icon-edit icon-lista'></i></a></td>";
        $htmlTable .= "  <td><a href='javascript:;' class='TbFuncionario_deletar' data-id='$vFunId'><i class='icon-trash icon-lista'></i></a></td>";
        $htmlTable .= "</tr>";
      }
    }

    $htmlTable .= "  </tbody>";
    $htmlTable .= "</table>";

    return $htmlTable;
  }

  public function getFuncionario($funId){
    $arrRet                     = [];
    $arrRet["erro"]             = true;
    $arrRet["msg"]              = "";
    $arrRet["arrFuncionarioDados"]  = array();

    if(!is_numeric($funId)){
      $arrRet["erro"] = true;
      $arrRet["msg"]  = "ID inválido para buscar o funcionário!";
      return $arrRet;
    }

    $this->load->database();
    $this->db->select("fun_id, fun_nome, fun_cpf_cnpj, fun_rg_ie, fun_tel_ddd, fun_tel_numero, fun_cel_ddd, fun_cel_numero, fun_end_cep, fun_end_tp_lgr, fun_end_logradouro, fun_end_numero, fun_end_bairro, fun_end_cidade, fun_end_estado, fun_observacao, fun_ativo");
    $this->db->from("tb_funcionario");
    $this->db->where("fun_id", $funId);
    $query = $this->db->get();

    if($query->num_rows() > 0){
      $row = $query->row();

      $arrFuncionarioDados = [];
      $arrFuncionarioDados["fun_id"]             = $row->fun_id;
      $arrFuncionarioDados["fun_nome"]           = $row->fun_nome;
      $arrFuncionarioDados["fun_cpf_cnpj"]       = $row->fun_cpf_cnpj;
      $arrFuncionarioDados["fun_rg_ie"]          = $row->fun_rg_ie;
      $arrFuncionarioDados["fun_tel_ddd"]        = $row->fun_tel_ddd;
      $arrFuncionarioDados["fun_tel_numero"]     = $row->fun_tel_numero;
      $arrFuncionarioDados["fun_cel_ddd"]        = $row->fun_cel_ddd;
      $arrFuncionarioDados["fun_cel_numero"]     = $row->fun_cel_numero;
      $arrFuncionarioDados["fun_end_cep"]        = $row->fun_end_cep;
      $arrFuncionarioDados["fun_end_tp_lgr"]     = $row->fun_end_tp_lgr;
      $arrFuncionarioDados["fun_end_logradouro"] = $row->fun_end_logradouro;
      $arrFuncionarioDados["fun_end_numero"]     = $row->fun_end_numero;
      $arrFuncionarioDados["fun_end_bairro"]     = $row->fun_end_bairro;
      $arrFuncionarioDados["fun_end_cidade"]     = $row->fun_end_cidade;
      $arrFuncionarioDados["fun_end_estado"]     = $row->fun_end_estado;
      $arrFuncionarioDados["fun_observacao"]     = $row->fun_observacao;
      $arrFuncionarioDados["fun_ativo"]          = $row->fun_ativo;

      $arrRet["arrFuncionarioDados"] = $arrFuncionarioDados;
    }

    $arrRet["erro"] = false;
    return $arrRet;
  }

  public function getFuncionarios(){
    $arrRet                = [];
    $arrRet["erro"]        = true;
    $arrRet["msg"]         = "";
    $arrRet["arrFuncionarios"] = array();

    $this->load->database();
    $this->db->select("fun_id, fun_nome, fun_cpf_cnpj");
    $this->db->from("tb_funcionario");
    $this->db->where("fun_ativo", 1);
    $this->db->order_by("fun_nome", "asc");
    $query = $this->db->get();

    if($query->num_rows() > 0){
      $arrRs = $query->result_array();
      foreach($arrRs as $rs1){
        $arrFuncionarioDados = [];
        $arrFuncionarioDados["fun_id"]       = $rs1["fun_id"];
        $arrFuncionarioDados["fun_nome"]     = $rs1["fun_nome"];
        $arrFuncionarioDados["fun_cpf_cnpj"] = $rs1["fun_cpf_cnpj"];

        $arrRet["arrFuncionarios"][] = $arrFuncionarioDados;
      }
    }

    $arrRet["erro"] = false;
    return $arrRet;
  }

  private function validaInsert($arrFuncionarioDados){
    $arrRet         = [];
    $arrRet["erro"] = true;
    $arrRet["msg"]  = "";

    $vFunNome = (isset($arrFuncionarioDados["fun_nome"])) ? $arrFuncionarioDados["fun_nome"]: "";
    if( strlen($vFunNome) < 2 ){
      $arrRet["erro"] = true;
      $arrRet["msg"]  = "Por Favor, informe o nome!";
      return $arrRet;
    }

    // cpf duplicado
    $vFunCpfCnpj = isset($arrFuncionarioDados["fun_cpf_cnpj"]) ? $arrFuncionarioDados["fun_cpf_cnpj"]: "";

    $this->load->helper('utils');
    $validCPF = is_cpf($vFunCpfCnpj);
    if(!$validCPF){
      $arrRet["erro"] = true;
      $arrRet["msg"]  = "CPF inválido!";
      return $arrRet;
    }

    if($vFunCpfCnpj != ""){
      $this->load->database();
      $this->db->select("fun_id");
      $this->db->from("tb_funcionario");
      $this->db->where("fun_cpf_cnpj", $vFunCpfCnpj);
      $this->db->where("fun_cpf_cnpj IS NOT NULL");
      $query = $this->db->get();
      if($query->num_rows() > 0){
        $row    = $query->row();
        $vFunId = $row->fun_id;

        $arrRet["erro"] = true;
        $arrRet["msg"]  = "Já existe um funcionário com esse CPF/CNPJ (ID $vFunId)! Verifique!";
        return $arrRet;
      }
      $this->db->reset_query();
    }
    // ===================

    // rg duplicado
    $vFunRgIe = isset($arrFuncionarioDados["fun_rg_ie"]) ? $arrFuncionarioDados["fun_rg_ie"]: "";

    if($vFunRgIe != ""){
      $this->load->database();
      $this->db->select("fun_id");
      $this->db->from("tb_funcionario");
      $this->db->where("fun_rg_ie", $vFunRgIe);
      $this->db->where("fun_rg_ie IS NOT NULL");
      $query = $this->db->get();
      if($query->num_rows() > 0){
        $row    = $query->row();
        $vFunId = $row->fun_id;

        $arrRet["erro"] = true;
        $arrRet["msg"]  = "Já existe um funcionário com esse RG/IE (ID $vFunId)! Verifique!";
        return $arrRet;
      }
      $this->db->reset_query();
    }
    // ===================

    $vAtivo = (isset($arrFuncionarioDados["fun_ativo"])) ? $arrFuncionarioDados["fun_ativo"]: "";
    if($vAtivo != 1 && $vAtivo != 0){
      $arrRet["erro"] = true;
      $arrRet["msg"]  = "Por Favor, informe se o funcionário está ativo!";
      return $arrRet;
    }

    $arrRet["erro"] = false;
    $arrRet["msg"]  = "";
    return $arrRet;
  }

  public function insert($arrFuncionarioDados){
    $arrRet         = [];
    $arrRet["erro"] = true;
    $arrRet["msg"]  = "";

    $retValidacao = $this->validaInsert($arrFuncionarioDados);
    if($retValidacao["erro"]){
      return $retValidacao;
    }

    $this->load->database();

    $vFunNome          = isset($arrFuncionarioDados["fun_nome"]) ? $arrFuncionarioDados["fun_nome"]: "null";
    $vFunCpfCnpj       = isset($arrFuncionarioDados["fun_cpf_cnpj"]) ? $arrFuncionarioDados["fun_cpf_cnpj"]: "null";
    $vFunRgIe          = isset($arrFuncionarioDados["fun_rg_ie"]) ? $arrFuncionarioDados["fun_rg_ie"]: "null";
    $vFunTelDdd        = isset($arrFuncionarioDados["fun_tel_ddd"]) ? $arrFuncionarioDados["fun_tel_ddd"]: "null";
    $vFunTelNumero     = isset($arrFuncionarioDados["fun_tel_numero"]) ? $arrFuncionarioDados["fun_tel_numero"]: "null";
    $vFunCelDdd        = isset($arrFuncionarioDados["fun_cel_ddd"]) ? $arrFuncionarioDados["fun_cel_ddd"]: "null";
    $vFunCelNumero     = isset($arrFuncionarioDados["fun_cel_numero"]) ? $arrFuncionarioDados["fun_cel_numero"]: "null";
    $vFunEndCep        = isset($arrFuncionarioDados["fun_end_cep"]) ? $arrFuncionarioDados["fun_end_cep"]: "null";
    $vFunEndTpLgr      = isset($arrFuncionarioDados["fun_end_tp_lgr"]) ? $arrFuncionarioDados["fun_end_tp_lgr"]: "null";
    $vFunEndLogradouro = isset($arrFuncionarioDados["fun_end_logradouro"]) ? $arrFuncionarioDados["fun_end_logradouro"]: "null";
    $vFunEndNumero     = isset($arrFuncionarioDados["fun_end_numero"]) ? $arrFuncionarioDados["fun_end_numero"]: "null";
    $vFunEndBairro     = isset($arrFuncionarioDados["fun_end_bairro"]) ? $arrFuncionarioDados["fun_end_bairro"]: "null";
    $vFunEndCidade     = isset($arrFuncionarioDados["fun_end_cidade"]) ? $arrFuncionarioDados["fun_end_cidade"]: "null";
    $vFunEndEstado     = isset($arrFuncionarioDados["fun_end_estado"]) ? $arrFuncionarioDados["fun_end_estado"]: "null";
    $vFunObs           = isset($arrFuncionarioDados["fun_observacao"]) ? $arrFuncionarioDados["fun_observacao"]: "null";
    $vFunAtivo         = isset($arrFuncionarioDados["fun_ativo"]) ? $arrFuncionarioDados["fun_ativo"]: "null";

    $data = array(
      'fun_nome'           => $vFunNome,
      'fun_cpf_cnpj'       => $vFunCpfCnpj,
      'fun_rg_ie'          => $vFunRgIe,
      'fun_tel_ddd'        => $vFunTelDdd,
      'fun_tel_numero'     => $vFunTelNumero,
      'fun_cel_ddd'        => $vFunCelDdd,
      'fun_cel_numero'     => $vFunCelNumero,
      'fun_end_cep'        => $vFunEndCep,
      'fun_end_tp_lgr'     => $vFunEndTpLgr,
      'fun_end_logradouro' => $vFunEndLogradouro,
      'fun_end_numero'     => $vFunEndNumero,
      'fun_end_bairro'     => $vFunEndBairro,
      'fun_end_cidade'     => $vFunEndCidade,
      'fun_end_estado'     => $vFunEndEstado,
      'fun_observacao'     => $vFunObs,
      'fun_ativo'          => $vFunAtivo,
    );

    $retInsert = $this->db->insert('tb_funcionario', $data);
    if(!$retInsert){
      $arrRet["erro"] = true;
      $arrRet["msg"]  = $this->db->_error_message();
    } else {
      $arrRet["erro"] = false;
      $arrRet["msg"]  = "funcionário inserido com sucesso!";
    }

    return $arrRet;
  }

  private function validaEdit($arrFuncionarioDados){
    $arrRet         = [];
    $arrRet["erro"] = true;
    $arrRet["msg"]  = "";

    $vFunId = (isset($arrFuncionarioDados["fun_id"])) ? $arrFuncionarioDados["fun_id"]: "";
    if(!$vFunId > 0){
      $arrRet["erro"] = true;
      $arrRet["msg"]  = "Não é possível editar! ID do funcionário não informado!";
      return $arrRet;
    }

    $vFunNome = (isset($arrFuncionarioDados["fun_nome"])) ? $arrFuncionarioDados["fun_nome"]: "";
    if( strlen($vFunNome) < 2 ){
      $arrRet["erro"] = true;
      $arrRet["msg"]  = "Por Favor, informe o nome!";
      return $arrRet;
    }

    // cpf duplicado
    $vFunCpfCnpj = isset($arrFuncionarioDados["fun_cpf_cnpj"]) ? $arrFuncionarioDados["fun_cpf_cnpj"]: "";

    $this->load->helper('utils');
    $validCPF = is_cpf($vFunCpfCnpj);
    if(!$validCPF){
      $arrRet["erro"] = true;
      $arrRet["msg"]  = "CPF inválido!";
      return $arrRet;
    }

    if($vFunCpfCnpj != ""){
      $this->load->database();
      $this->db->select("fun_id");
      $this->db->from("tb_funcionario");
      $this->db->where("fun_cpf_cnpj", $vFunCpfCnpj);
      $this->db->where("fun_cpf_cnpj IS NOT NULL");
      $this->db->where("fun_id <> $vFunId");
      $query = $this->db->get();
      if($query->num_rows() > 0){
        $row    = $query->row();
        $vFunId = $row->fun_id;

        $arrRet["erro"] = true;
        $arrRet["msg"]  = "Já existe um funcionário com esse CPF/CNPJ (ID $vFunId)! Verifique!";
        return $arrRet;
      }
      $this->db->reset_query();
    }
    // ===================

    // rg duplicado
    $vFunRgIe = isset($arrFuncionarioDados["fun_rg_ie"]) ? $arrFuncionarioDados["fun_rg_ie"]: "";

    if($vFunRgIe != ""){
      $this->load->database();
      $this->db->select("fun_id");
      $this->db->from("tb_funcionario");
      $this->db->where("fun_rg_ie", $vFunRgIe);
      $this->db->where("fun_rg_ie IS NOT NULL");
      $this->db->where("fun_id <> $vFunId");
      $query = $this->db->get();
      if($query->num_rows() > 0){
        $row    = $query->row();
        $vFunId = $row->fun_id;

        $arrRet["erro"] = true;
        $arrRet["msg"]  = "Já existe um funcionário com esse RG/IE (ID $vFunId)! Verifique!";
        return $arrRet;
      }
      $this->db->reset_query();
    }
    // ===================

    $vAtivo = (isset($arrFuncionarioDados["fun_ativo"])) ? $arrFuncionarioDados["fun_ativo"]: "";
    if($vAtivo != 1 && $vAtivo != 0){
      $arrRet["erro"] = true;
      $arrRet["msg"]  = "Por Favor, informe se o funcionário está ativo!";
      return $arrRet;
    }

    $arrRet["erro"] = false;
    $arrRet["msg"]  = "";
    return $arrRet;
  }

  public function edit($arrFuncionarioDados){
    $arrRet         = [];
    $arrRet["erro"] = true;
    $arrRet["msg"]  = "";

    $retValidacao = $this->validaEdit($arrFuncionarioDados);
    if($retValidacao["erro"]){
      return $retValidacao;
    }

    $this->load->database();

    $vFunId            = isset($arrFuncionarioDados["fun_id"]) ? $arrFuncionarioDados["fun_id"]: "";
    $vFunNome          = isset($arrFuncionarioDados["fun_nome"]) ? $arrFuncionarioDados["fun_nome"]: "null";
    $vFunCpfCnpj       = isset($arrFuncionarioDados["fun_cpf_cnpj"]) ? $arrFuncionarioDados["fun_cpf_cnpj"]: "null";
    $vFunRgIe          = isset($arrFuncionarioDados["fun_rg_ie"]) ? $arrFuncionarioDados["fun_rg_ie"]: "null";
    $vFunTelDdd        = isset($arrFuncionarioDados["fun_tel_ddd"]) ? $arrFuncionarioDados["fun_tel_ddd"]: "null";
    $vFunTelNumero     = isset($arrFuncionarioDados["fun_tel_numero"]) ? $arrFuncionarioDados["fun_tel_numero"]: "null";
    $vFunCelDdd        = isset($arrFuncionarioDados["fun_cel_ddd"]) ? $arrFuncionarioDados["fun_cel_ddd"]: "null";
    $vFunCelNumero     = isset($arrFuncionarioDados["fun_cel_numero"]) ? $arrFuncionarioDados["fun_cel_numero"]: "null";
    $vFunEndCep        = isset($arrFuncionarioDados["fun_end_cep"]) ? $arrFuncionarioDados["fun_end_cep"]: "null";
    $vFunEndTpLgr      = isset($arrFuncionarioDados["fun_end_tp_lgr"]) ? $arrFuncionarioDados["fun_end_tp_lgr"]: "null";
    $vFunEndLogradouro = isset($arrFuncionarioDados["fun_end_logradouro"]) ? $arrFuncionarioDados["fun_end_logradouro"]: "null";
    $vFunEndNumero     = isset($arrFuncionarioDados["fun_end_numero"]) ? $arrFuncionarioDados["fun_end_numero"]: "null";
    $vFunEndBairro     = isset($arrFuncionarioDados["fun_end_bairro"]) ? $arrFuncionarioDados["fun_end_bairro"]: "null";
    $vFunEndCidade     = isset($arrFuncionarioDados["fun_end_cidade"]) ? $arrFuncionarioDados["fun_end_cidade"]: "null";
    $vFunEndEstado     = isset($arrFuncionarioDados["fun_end_estado"]) ? $arrFuncionarioDados["fun_end_estado"]: "null";
    $vFunObs           = isset($arrFuncionarioDados["fun_observacao"]) ? $arrFuncionarioDados["fun_observacao"]: "null";
    $vFunAtivo         = isset($arrFuncionarioDados["fun_ativo"]) ? $arrFuncionarioDados["fun_ativo"]: "null";

    $data = array(
      'fun_nome'           => $vFunNome,
      'fun_cpf_cnpj'       => $vFunCpfCnpj,
      'fun_rg_ie'          => $vFunRgIe,
      'fun_tel_ddd'        => $vFunTelDdd,
      'fun_tel_numero'     => $vFunTelNumero,
      'fun_cel_ddd'        => $vFunCelDdd,
      'fun_cel_numero'     => $vFunCelNumero,
      'fun_end_cep'        => $vFunEndCep,
      'fun_end_tp_lgr'     => $vFunEndTpLgr,
      'fun_end_logradouro' => $vFunEndLogradouro,
      'fun_end_numero'     => $vFunEndNumero,
      'fun_end_bairro'     => $vFunEndBairro,
      'fun_end_cidade'     => $vFunEndCidade,
      'fun_end_estado'     => $vFunEndEstado,
      'fun_observacao'     => $vFunObs,
      'fun_ativo'          => $vFunAtivo,
    );

    $this->db->where('fun_id', $vFunId);
    $retInsert = $this->db->update('tb_funcionario', $data);

    if(!$retInsert){
      $arrRet["erro"] = true;
      $arrRet["msg"]  = $this->db->_error_message();
    } else {
      $arrRet["erro"] = false;
      $arrRet["msg"]  = "funcionário alterado com sucesso!";
    }

    return $arrRet;
  }
}
