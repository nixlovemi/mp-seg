<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FuncionarioEscala extends MY_Controller {
  public function __construct(){
    parent::__construct();
  }

  public function jsonDelEscala(){
    $this->load->helper('utils');

    $arrRet = [];
    $arrRet["erro"]            = false;
    $arrRet["msg"]             = "";

    // variaveis ============
    $vfueId = $this->input->post('fueId');
    // ======================

    $this->load->model('Tb_Funcionario_Escala');
    $retInsert = $this->Tb_Funcionario_Escala->delete($vfueId);
    if( $retInsert["erro"] ){
      $arrRet["erro"] = true;
      $arrRet["msg"]  = "Erro ao deletar Escala. Msg: " . $retInsert["msg"];

      echo json_encode($arrRet);
      return;
    }

    echo json_encode($arrRet);
  }

  public function jsonHtmlEditEscala(){
    $data   = [];
    $arrRet = [];
    $arrRet["html"] = "";
    $arrRet["msg"]  = "";
    $arrRet["erro"] = false;

    $fueId = $this->input->post('fueId');

    $this->load->model('Tb_Funcionario_Escala');
    $retEscalaFunc = $this->Tb_Funcionario_Escala->getFuncionarioEscala($fueId);

    if($retEscalaFunc["erro"]){
      $arrRet["erro"] = true;
      $arrRet["msg"]  = "Erro ao buscar Escala. Msg: " . $retEscalaFunc["msg"];
    } else {
      $FuncionarioEscala         = $retEscalaFunc["arrFuncEscalaDados"];
      $data["FuncionarioEscala"] = $FuncionarioEscala;
      $data["editar"]            = true;
    }

    $this->load->model('Tb_Cliente');
    $retClientes = $this->Tb_Cliente->getClientes();
    $arrClientes = (!$retClientes["erro"]) ? $retClientes["arrClientes"]: array();
    $data["arrClientes"] = $arrClientes;

    $this->load->model('Tb_Funcionario');
    $retFuncionario = $this->Tb_Funcionario->getFuncionarios();
    $arrFuncionario = (!$retFuncionario["erro"]) ? $retFuncionario["arrFuncionarios"]: array();
    $data["arrFuncionario"] = $arrFuncionario;

    $htmlView       = $this->load->view('FuncionarioEscala/novo', $data, true);
    $arrRet["html"] = $htmlView;
    echo json_encode($arrRet);
  }

  public function jsonEditFuncEscala(){
    $this->load->helper('utils');

    $arrRet = [];
    $arrRet["erro"] = false;
    $arrRet["msg"]  = "";

    // variaveis ============
    $vFueId     = $this->input->post('fueId') > 0 ? $this->input->post('fueId'): -1;
    $vFueFunId  = ($this->input->post('fueFunId') > 0) ? $this->input->post('fueFunId'): null;
    $vFueCliId  = ($this->input->post('fueCliId') > 0) ? $this->input->post('fueCliId'): null;
    $vFueDtIni  = (strlen($this->input->post('fueDtIni')) == 10) ? acerta_data($this->input->post('fueDtIni')): "";
    $vFueHrIni  = (strlen($this->input->post('fueDtIniHora')) == 5) ? $this->input->post('fueDtIniHora'): "";
    $vFueDtFim  = (strlen($this->input->post('fueDtFim')) == 10) ? acerta_data($this->input->post('fueDtFim')): "";
    $vFueHrFim  = (strlen($this->input->post('fueDtFimHora')) == 5) ? $this->input->post('fueDtFimHora'): "";
    $vFueObs    = ($this->input->post('fueObs') != "") ? $this->input->post('fueObs'): null;
    // ======================

    $this->load->model('Tb_Funcionario_Escala');

    $FuncionarioEscala = [];
    $FuncionarioEscala["fue_id"]       = $vFueId;
    $FuncionarioEscala["fue_fun_id"]   = $vFueFunId;
    $FuncionarioEscala["fue_cli_id"]   = $vFueCliId;
    $FuncionarioEscala["fue_dtinicio"] = $vFueDtIni . " " . $vFueHrIni;
    $FuncionarioEscala["fue_dtfim"]    = $vFueDtFim . " " . $vFueHrFim;
    $FuncionarioEscala["fue_obs"]      = $vFueObs;

    $retInsert = $this->Tb_Funcionario_Escala->edit($FuncionarioEscala);
    if( $retInsert["erro"] ){
      $arrRet["erro"] = true;
      $arrRet["msg"]  = "Erro ao editar escala. Msg: " . $retInsert["msg"];

      echo json_encode($arrRet);
      return;
    } else {
      $arrRet["erro"] = false;
      $arrRet["msg"]  = "Escala editada com sucesso.";

      echo json_encode($arrRet);
      return;
    }
  }

  public function jsonHtmlAddEscala(){
    $data   = [];
    $arrRet = [];
    $arrRet["html"] = "";
    $arrRet["msg"]  = "";
    $arrRet["erro"] = false;

    $funId = $this->input->post('funId');

    $this->load->model('Tb_Cliente');
    $retClientes = $this->Tb_Cliente->getClientes();
    $arrClientes = (!$retClientes["erro"]) ? $retClientes["arrClientes"]: array();
    $data["arrClientes"] = $arrClientes;

    $this->load->model('Tb_Funcionario');
    $retFuncionario = $this->Tb_Funcionario->getFuncionarios();
    $arrFuncionario = (!$retFuncionario["erro"]) ? $retFuncionario["arrFuncionarios"]: array();
    $data["funId"]  = $funId;

    $data["arrFuncionario"] = $arrFuncionario;
    $htmlView        = $this->load->view('FuncionarioEscala/novo', $data, true);
    $arrRet["html"]  = $htmlView;
    echo json_encode($arrRet);
  }

  public function jsonAddFuncEscala(){
    $this->load->helper('utils');

    $arrRet = [];
    $arrRet["erro"] = false;
    $arrRet["msg"]  = "";

    // variaveis ============
    $vFueFunId  = ($this->input->post('fueFunId') > 0) ? $this->input->post('fueFunId'): null;
    $vFueCliId  = ($this->input->post('fueCliId') > 0) ? $this->input->post('fueCliId'): null;
    $vFueDtIni  = (strlen($this->input->post('fueDtIni')) == 10) ? acerta_data($this->input->post('fueDtIni')): "";
    $vFueHrIni  = (strlen($this->input->post('fueDtIniHora')) == 5) ? $this->input->post('fueDtIniHora'): "";
    $vFueDtFim  = (strlen($this->input->post('fueDtFim')) == 10) ? acerta_data($this->input->post('fueDtFim')): "";
    $vFueHrFim  = (strlen($this->input->post('fueDtFimHora')) == 5) ? $this->input->post('fueDtFimHora'): "";
    $vFueObs    = ($this->input->post('fueObs') != "") ? $this->input->post('fueObs'): null;
    // ======================

    $this->load->model('Tb_Funcionario_Escala');

    $FuncionarioEscala = [];
    $FuncionarioEscala["fue_fun_id"]   = $vFueFunId;
    $FuncionarioEscala["fue_cli_id"]   = $vFueCliId;
    $FuncionarioEscala["fue_dtinicio"] = $vFueDtIni . " " . $vFueHrIni;
    $FuncionarioEscala["fue_dtfim"]    = $vFueDtFim . " " . $vFueHrFim;
    $FuncionarioEscala["fue_obs"]      = $vFueObs;

    $retInsert = $this->Tb_Funcionario_Escala->insert($FuncionarioEscala);
    if( $retInsert["erro"] ){
      $arrRet["erro"] = true;
      $arrRet["msg"]  = "Erro ao inserir escala. Msg: " . $retInsert["msg"];

      echo json_encode($arrRet);
      return;
    } else {
      $arrRet["erro"] = false;
      $arrRet["msg"]  = "Escala inserida com sucesso.";

      echo json_encode($arrRet);
      return;
    }
  }
}
