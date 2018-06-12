<?php
class Tb_Funcionario_Escala extends CI_Model {
  private function getArrCorEvento($idx){
    $arrCorEventos = [];

    // cores
    $arrCorEventos[0] = array(
      "fundo" => "red",
      "texto" => "yellow",
    );

    $arrCorEventos[1] = array(
      "fundo" => "orange",
      "texto" => "black",
    );

    $arrCorEventos[2] = array(
      "fundo" => "yellow",
      "texto" => "blue",
    );

    $arrCorEventos[3] = array(
      "fundo" => "green",
      "texto" => "black",
    );

    $arrCorEventos[4] = array(
      "fundo" => "blue",
      "texto" => "yellow",
    );

    $arrCorEventos[5] = array(
      "fundo" => "violet",
      "texto" => "white",
    );

    $arrCorEventos[6] = array(
      "fundo" => "black",
      "texto" => "red",
    );

    $arrCorEventos[7] = array(
      "fundo" => "grey",
      "texto" => "yellow",
    );

    $arrCorEventos[8] = array(
      "fundo" => "red",
      "texto" => "white",
    );

    $arrCorEventos[9] = array(
      "fundo" => "orange",
      "texto" => "yellow",
    );

    $arrCorEventos[10] = array(
      "fundo" => "yellow",
      "texto" => "red",
    );

    $arrCorEventos[11] = array(
      "fundo" => "green",
      "texto" => "blue",
    );

    $arrCorEventos[12] = array(
      "fundo" => "blue",
      "texto" => "white",
    );

    $arrCorEventos[13] = array(
      "fundo" => "violet",
      "texto" => "black",
    );

    $arrCorEventos[14] = array(
      "fundo" => "black",
      "texto" => "orange",
    );

    $arrCorEventos[15] = array(
      "fundo" => "grey",
      "texto" => "green",
    );

    $arrCorEventos[16] = array(
      "fundo" => "orange",
      "texto" => "white",
    );

    $arrCorEventos[17] = array(
      "fundo" => "yellow",
      "texto" => "violet",
    );

    $arrCorEventos[18] = array(
      "fundo" => "black",
      "texto" => "green",
    );

    $arrCorEventos[19] = array(
      "fundo" => "grey",
      "texto" => "white",
    );

    $arrCorEventos[20] = array(
      "fundo" => "yellow",
      "texto" => "violet",
    );

    $arrCorEventos[21] = array(
      "fundo" => "black",
      "texto" => "white",
    );

    $arrCorEventos[22] = array(
      "fundo" => "yellow",
      "texto" => "black",
    );

    $arrCorEventos[23] = array(
      "fundo" => "black",
      "texto" => "violet",
    );

    $arrCorEventos[24] = array(
      "fundo" => "yellow",
      "texto" => "gray",
    );

    $arrCorEventos[25] = array(
      "fundo" => "black",
      "texto" => "yellow",
    );
    // =====

    return (isset($arrCorEventos[$idx])) ? $arrCorEventos[$idx]: array(
      "fundo" => "black",
      "texto" => "yellow",
    );
  }

  public function getArrEscalaFunc(){
    $arrRet            = [];
    $arrRet["erro"]    = true;
    $arrRet["msg"]     = "";
    $arrRet["Eventos"] = array();

    $this->load->database();
    $this->db->select("fue_id, fue_fun_id, fun_nome, fue_cli_id, cli_nome, fue_dtinicio, fue_dtfim");
    $this->db->from("tb_funcionario_escala");
    $this->db->join('tb_funcionario', "fun_id = fue_fun_id", 'left');
    $this->db->join('tb_cliente', "cli_id = fue_cli_id", 'left');
    $this->db->where("1=1");
    $this->db->order_by("fun_nome, cli_nome, fue_dtinicio");

    $query = $this->db->get();
    $arrRs = $query->result_array();
    $arrItensFunc = [];

    foreach($arrRs as $row){
      $fueId   = $row["fue_id"];
      $funId   = $row["fue_fun_id"];
      $funNome = $row["fun_nome"];
      $cliId   = $row["fue_cli_id"];
      $cliNome = $row["cli_nome"];
      $dtIni   = $row["fue_dtinicio"];
      $dtFim   = $row["fue_dtfim"];

      if( !array_key_exists($funId, $arrItensFunc) ){
        $arrItensFunc[$funId] = [];
      }

      $arrItensFunc[$funId]["info"][] = array(
        "fueId"   => $fueId,
        "funNome" => $funNome,
        "cliId"   => $cliId,
        "cliNome" => $cliNome,
        "dtIni"   => $dtIni,
        "dtFim"   => $dtFim,
      );
    }

    // formata o array pro calendario
    $arrEventos = [];

    $i = 0;
    foreach($arrItensFunc as $funId => $dados){
      $arrCor = $this->getArrCorEvento($i);

      $arrEvento["events"]    = [];
      $arrEvento["color"]     = $arrCor["fundo"];
      $arrEvento["textColor"] = $arrCor["texto"];

      $arrDados = $dados["info"];
      foreach($arrDados as $info){
        $fueId   = $info["fueId"];
        $funNome = $info["funNome"];
        $cliId   = $info["cliId"];
        $cliNome = strtoupper($info["cliNome"]);
        $dtIni   = $info["dtIni"];
        $dtFim   = $info["dtFim"];

        $arrEvento["events"][] = array(
          "allDay" => false,
          "id"     => $fueId,
          "title"  => "$funNome >> Cliente: $cliNome",
          "start"  => date("Y-m-d", strtotime($dtIni)) . "T" . date("H:i", strtotime($dtIni)),
          "end"    => date("Y-m-d", strtotime($dtFim)) . "T" . date("H:i", strtotime($dtFim)),
        );
      }

      $Eventos[] = $arrEvento;
      $i++;
    }
    // ==============================

    $arrRet["erro"]    = false;
    $arrRet["Eventos"] = $Eventos;

    return $arrRet;
  }

  public function htmlLstEscalaFunc($arrFilters=[]){
    $arrRet = [];
    $arrRet["erro"] = false;
    $arrRet["msg"]  = "";
    $arrRet["html"] = "";

    // variaveis
    $fueFunId    = isset($arrFilters["fue_fun_id"]) ? $arrFilters["fue_fun_id"]: "";
    $fueDtInicio = isset($arrFilters["fue_dtinicio"]) ? $arrFilters["fue_dtinicio"]: "";
    $fueDtFim    = isset($arrFilters["fue_dtfim"]) ? $arrFilters["fue_dtfim"]: "";
    // =========

    $this->load->database();
    $this->db->select("fue_id, fue_fun_id, fun_nome, fue_cli_id, cli_nome, fue_dtinicio, fue_dtfim, fue_obs");
    $this->db->from("tb_funcionario_escala");
    $this->db->join('tb_funcionario', "fun_id = fue_fun_id", 'left');
    $this->db->join('tb_cliente', "cli_id = fue_cli_id", 'left');
    $this->db->where("1=1");
    if(is_numeric($fueFunId)){
      $this->db->where("fue_fun_id = $fueFunId");
    }
    if(strlen($fueDtInicio) == 10){
      $this->db->where("fue_dtinicio >= '$fueDtInicio'");
    }
    if(strlen($fueDtFim) == 10){
      $this->db->where("fue_dtinicio <= '$fueDtFim'");
    }
    $this->db->order_by("fun_nome, cli_nome, fue_dtinicio");

    $query = $this->db->get();
    $arrRs = $query->result_array();

    $htmlTable  = "";
    $htmlTable .= "<input style='margin: 8px 0 20px 8px;' type='button' value='NOVA ESCALA' class='btn btn-success TbFuncionarioEscala_ajax_add' />";
    $htmlTable .= "<table class='table table-bordered' id='tbProdutoGetHtmlList'>";
    $htmlTable .= "  <thead>";
    $htmlTable .= "    <tr>";
    $htmlTable .= "      <th>Funcionário</th>";
    $htmlTable .= "      <th>Cliente</th>";
    $htmlTable .= "      <th width='9%'>Início</th>";
    $htmlTable .= "      <th width='9%'>Fim</th>";
    $htmlTable .= "      <th>Observação</th>";
    $htmlTable .= "      <th width='7%'>Editar</th>";
    $htmlTable .= "      <th width='7%'>Deletar</th>";
    $htmlTable .= "    </tr>";
    $htmlTable .= "  </thead>";
    $htmlTable .= "  <tbody>";

    foreach($arrRs as $row){
      $fueId   = $row["fue_id"];
      $funNome = $row["fun_nome"];
      $cliNome = $row["cli_nome"];
      $dtIni   = date("d/m/Y H:i", strtotime($row["fue_dtinicio"]));
      $dtFim   = date("d/m/Y H:i", strtotime($row["fue_dtfim"]));
      $obs     = "<small>" . $row["fue_obs"] . "</small>";

      $htmlTable .= "  <tr>";
      $htmlTable .= "    <td>$funNome</td>";
      $htmlTable .= "    <td>$cliNome</td>";
      $htmlTable .= "    <td width='9%'>$dtIni</td>";
      $htmlTable .= "    <td width='9%'>$dtFim</td>";
      $htmlTable .= "    <td>$obs</td>";
      $htmlTable .= "    <td width='7%'><a href='javascript:;' class='TbFuncionarioEscala_ajax_alterar' data-id='$fueId'><i class='icon-edit icon-lista'></i></a></td>";
      $htmlTable .= "    <td width='7%'><a href='javascript:;' class='TbFuncionarioEscala_ajax_deletar' data-id='$fueId'><i class='icon-trash icon-lista'></i></a></td>";
      $htmlTable .= "  </tr>";
    }

    $htmlTable .= "  </tbody>";
    $htmlTable .= "</table>";

    $arrRet["html"] = $htmlTable;
    return $arrRet;
  }

  private function validaInsert($arrFuncionarioEscala){
    $this->load->helper('utils');

    $arrRet         = [];
    $arrRet["erro"] = true;
    $arrRet["msg"]  = "";

    $vFunId = (isset($arrFuncionarioEscala["fue_fun_id"])) ? $arrFuncionarioEscala["fue_fun_id"]: "";
    if( $vFunId == "" ){
      $arrRet["erro"] = true;
      $arrRet["msg"]  = "A Escala precisa ter um Funcionário!";
      return $arrRet;
    }

    $vCliId = (isset($arrFuncionarioEscala["fue_cli_id"])) ? $arrFuncionarioEscala["fue_cli_id"]: "";
    if( $vCliId == "" ){
      $arrRet["erro"] = true;
      $arrRet["msg"]  = "A Escala precisa ter um Cliente!";
      return $arrRet;
    }

    $vData       = (isset($arrFuncionarioEscala["fue_dtinicio"])) ? $arrFuncionarioEscala["fue_dtinicio"]: "";
    $isVctoValid = isValidDate($vData, "Y-m-d H:i");
    if(!$isVctoValid){
      $arrRet["erro"] = true;
      $arrRet["msg"]  = "Por favor, informe uma data inicial válida!";
      return $arrRet;
    }

    $vDataFim    = (isset($arrFuncionarioEscala["fue_dtfim"])) ? $arrFuncionarioEscala["fue_dtfim"]: "";
    $isVctoValid = isValidDate($vDataFim, "Y-m-d H:i");
    if(!$isVctoValid){
      $arrRet["erro"] = true;
      $arrRet["msg"]  = "Por favor, informe uma data final válida!";
      return $arrRet;
    }

    $arrRet["erro"] = false;
    $arrRet["msg"]  = "";
    return $arrRet;
  }

  public function insert($arrFuncionarioEscala){
    $arrRet         = [];
    $arrRet["erro"] = true;
    $arrRet["msg"]  = "";

    $retValidacao = $this->validaInsert($arrFuncionarioEscala);
    if($retValidacao["erro"]){
      return $retValidacao;
    }

    $this->load->database();

    $vFunId    = isset($arrFuncionarioEscala["fue_fun_id"]) && $arrFuncionarioEscala["fue_fun_id"] > 0 ? $arrFuncionarioEscala["fue_fun_id"]: null;
    $vCliId    = isset($arrFuncionarioEscala["fue_cli_id"]) && $arrFuncionarioEscala["fue_cli_id"] > 0 ? $arrFuncionarioEscala["fue_cli_id"]: null;
    $vDtIni    = isset($arrFuncionarioEscala["fue_dtinicio"]) && $arrFuncionarioEscala["fue_dtinicio"] != "" ? $arrFuncionarioEscala["fue_dtinicio"]: null;
    $vDtFim    = isset($arrFuncionarioEscala["fue_dtfim"]) && $arrFuncionarioEscala["fue_dtfim"] != "" ? $arrFuncionarioEscala["fue_dtfim"]: null;
    $vObs      = isset($arrFuncionarioEscala["fue_obs"]) && $arrFuncionarioEscala["fue_obs"] != "" ? $arrFuncionarioEscala["fue_obs"]: "";

    $FuncionarioEscala["fue_fun_id"]   = $vFunId;
    $FuncionarioEscala["fue_cli_id"]   = $vCliId;
    $FuncionarioEscala["fue_dtinicio"] = $vDtIni;
    $FuncionarioEscala["fue_dtfim"]    = $vDtFim;
    $FuncionarioEscala["fue_obs"]      = $vObs;

    $retInsert = $this->db->insert('tb_funcionario_escala', $FuncionarioEscala);
    if(!$retInsert){
      $arrRet["erro"] = true;
      $arrRet["msg"]  = $this->db->_error_message();
    } else {
      $arrRet["erro"] = false;
      $arrRet["msg"]  = "Escala inserida com sucesso!";
    }

    return $arrRet;
  }

  private function validaEdit($arrFuncionarioEscala){
    $this->load->helper('utils');

    $arrRet         = [];
    $arrRet["erro"] = true;
    $arrRet["msg"]  = "";

    $vFueId = (isset($arrFuncionarioEscala["fue_id"])) ? $arrFuncionarioEscala["fue_id"]: "";
    if(!$vFueId > 0){
      $arrRet["erro"] = true;
      $arrRet["msg"]  = "ID inválido para editar a Escala!";
      return $arrRet;
    }

    $vFunId = (isset($arrFuncionarioEscala["fue_fun_id"])) ? $arrFuncionarioEscala["fue_fun_id"]: "";
    if( $vFunId == "" ){
      $arrRet["erro"] = true;
      $arrRet["msg"]  = "A Escala precisa ter um Funcionário!";
      return $arrRet;
    }

    $vCliId = (isset($arrFuncionarioEscala["fue_cli_id"])) ? $arrFuncionarioEscala["fue_cli_id"]: "";
    if( $vCliId == "" ){
      $arrRet["erro"] = true;
      $arrRet["msg"]  = "A Escala precisa ter um Cliente!";
      return $arrRet;
    }

    $vData       = (isset($arrFuncionarioEscala["fue_dtinicio"])) ? $arrFuncionarioEscala["fue_dtinicio"]: "";
    $isVctoValid = isValidDate($vData, "Y-m-d H:i");
    if(!$isVctoValid){
      $arrRet["erro"] = true;
      $arrRet["msg"]  = "Por favor, informe uma data inicial válida!";
      return $arrRet;
    }

    $vDataFim    = (isset($arrFuncionarioEscala["fue_dtfim"])) ? $arrFuncionarioEscala["fue_dtfim"]: "";
    $isVctoValid = isValidDate($vDataFim, "Y-m-d H:i");
    if(!$isVctoValid){
      $arrRet["erro"] = true;
      $arrRet["msg"]  = "Por favor, informe uma data final válida!";
      return $arrRet;
    }

    $arrRet["erro"] = false;
    $arrRet["msg"]  = "";
    return $arrRet;
  }

  public function edit($arrFuncionarioEscala){
    $arrRet         = [];
    $arrRet["erro"] = true;
    $arrRet["msg"]  = "";

    $retValidacao = $this->validaEdit($arrFuncionarioEscala);
    if($retValidacao["erro"]){
      return $retValidacao;
    }

    $this->load->database();

    $vFueId    = isset($arrFuncionarioEscala["fue_id"]) && $arrFuncionarioEscala["fue_id"] > 0 ? $arrFuncionarioEscala["fue_id"]: null;
    $vFunId    = isset($arrFuncionarioEscala["fue_fun_id"]) && $arrFuncionarioEscala["fue_fun_id"] > 0 ? $arrFuncionarioEscala["fue_fun_id"]: null;
    $vCliId    = isset($arrFuncionarioEscala["fue_cli_id"]) && $arrFuncionarioEscala["fue_cli_id"] > 0 ? $arrFuncionarioEscala["fue_cli_id"]: null;
    $vDtIni    = isset($arrFuncionarioEscala["fue_dtinicio"]) && $arrFuncionarioEscala["fue_dtinicio"] != "" ? $arrFuncionarioEscala["fue_dtinicio"]: null;
    $vDtFim    = isset($arrFuncionarioEscala["fue_dtfim"]) && $arrFuncionarioEscala["fue_dtfim"] != "" ? $arrFuncionarioEscala["fue_dtfim"]: null;
    $vObs      = isset($arrFuncionarioEscala["fue_obs"]) && $arrFuncionarioEscala["fue_obs"] != "" ? $arrFuncionarioEscala["fue_obs"]: "";

    $FuncionarioEscala["fue_fun_id"]   = $vFunId;
    $FuncionarioEscala["fue_cli_id"]   = $vCliId;
    $FuncionarioEscala["fue_dtinicio"] = $vDtIni;
    $FuncionarioEscala["fue_dtfim"]    = $vDtFim;
    $FuncionarioEscala["fue_obs"]      = $vObs;

    $this->db->where('fue_id', $vFueId);
    $retInsert = $this->db->update('tb_funcionario_escala', $FuncionarioEscala);
    if(!$retInsert){
      $arrRet["erro"] = true;
      $arrRet["msg"]  = $this->db->_error_message();
    } else {
      $arrRet["erro"] = false;
      $arrRet["msg"]  = "Escala editada com sucesso!";
    }

    return $arrRet;
  }

  public function delete($fueId){
    $arrRet                     = [];
    $arrRet["erro"]             = true;
    $arrRet["msg"]              = "";

    if(!is_numeric($fueId)){
      $arrRet["erro"] = true;
      $arrRet["msg"]  = "ID inválido para deletar a escala!";
      return $arrRet;
    }

    $this->load->database();

    $sql = "DELETE FROM tb_funcionario_escala WHERE fue_id = $fueId";
    $this->db->query($sql);

    $arrRet["erro"] = false;
    return $arrRet;
  }

  public function getFuncionarioEscala($fueId){
    $arrRet                     = [];
    $arrRet["erro"]             = true;
    $arrRet["msg"]              = "";
    $arrRet["arrFuncEscalaDados"]  = array();

    if(!is_numeric($fueId)){
      $arrRet["erro"] = true;
      $arrRet["msg"]  = "ID inválido para buscar a escala!";
      return $arrRet;
    }

    $this->load->database();
    $this->db->select("fue_id, fue_fun_id, fun_nome, fue_cli_id, cli_nome, fue_dtinicio, fue_dtfim, fue_obs");
    $this->db->from("tb_funcionario_escala");
    $this->db->join('tb_cliente', 'cli_id = fue_cli_id', 'left');
    $this->db->join('tb_funcionario', 'fun_id = fue_fun_id', 'left');
    $this->db->where("fue_id", $fueId);
    $query = $this->db->get();

    if($query->num_rows() > 0){
      $row = $query->row();

      $arrFuncEscalaDados = [];
      $arrFuncEscalaDados["fue_id"]       = $row->fue_id;
      $arrFuncEscalaDados["fue_fun_id"]   = $row->fue_fun_id;
      $arrFuncEscalaDados["fun_nome"]     = $row->fun_nome;
      $arrFuncEscalaDados["fue_cli_id"]   = $row->fue_cli_id;
      $arrFuncEscalaDados["cli_nome"]     = $row->cli_nome;
      $arrFuncEscalaDados["fue_dtinicio"] = $row->fue_dtinicio;
      $arrFuncEscalaDados["fue_dtfim"]    = $row->fue_dtfim;
      $arrFuncEscalaDados["fue_obs"]      = $row->fue_obs;

      $arrRet["arrFuncEscalaDados"] = $arrFuncEscalaDados;
    }

    $arrRet["erro"] = false;
    return $arrRet;
  }
}
