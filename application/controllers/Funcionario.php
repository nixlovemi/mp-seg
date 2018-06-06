<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Funcionario extends MY_Controller {
  public function __construct(){
    parent::__construct();
  }

	public function index(){
    $data     = [];
    $userData = $this->session->get_userdata();
    $errorMsg = isset($userData["FuncionarioIndex_error_msg"]) ? $userData["FuncionarioIndex_error_msg"]: "";

    if($errorMsg != ""){
      $this->load->helper('alerts');
      $errorMsg = showError($errorMsg);
      $this->session->unset_userdata('FuncionarioIndex_error_msg');
    }

    $this->load->model('Tb_Funcionario');
    $htmlFunTable         = $this->Tb_Funcionario->getHtmlList();
    $data["errorMsg"]     = $errorMsg;
    $data["htmlFunTable"] = $htmlFunTable;

    $this->template->load('template', 'Funcionario/index', $data);
	}

  public function ver($funId){
    // esquema para dynatables
    $queries = http_build_query($_GET);

    $this->load->model('Tb_Funcionario');
    $retFuncionario      = $this->Tb_Funcionario->getFuncionario($funId);
    $arrFuncionarioDados = [];
    if(!$retFuncionario["erro"]){
      $arrFuncionarioDados = $retFuncionario["arrFuncionarioDados"];
    }

    $this->load->model('Tb_Estado');
    $retEstados = $this->Tb_Estado->getEstados();
    $arrEstados = (!$retEstados["erro"]) ? $retEstados["arrEstados"]: array();

    $data = [];
    $data["detalhes"]         = true;
    $data["arrFuncionarioDados"] = $arrFuncionarioDados;
    $data["arrEstados"]       = $arrEstados;
    $data["errorMsg"]         = "";
    $data["okMsg"]            = "";
    $data["queries"]          = $queries;

    $this->template->load('template', 'Funcionario/novo', $data);
  }

  public function novoFuncionario(){
    $data = [];

    $this->load->model('Tb_Estado');
    $retEstados = $this->Tb_Estado->getEstados();
    $arrEstados = (!$retEstados["erro"]) ? $retEstados["arrEstados"]: array();

    $data["arrEstados"] = $arrEstados;
    $this->template->load('template', 'Funcionario/novo', $data);
  }

  public function salvaNovo(){
    $this->load->helper('utils');

    // variaveis ============
    $vFunNome          = $this->input->post('funNome');
    $vFunCpfCnpj       = $this->input->post('funCpfCnpj');
    $vFunRgIe          = $this->input->post('funRgIe');
    $vFunTelDdd        = $this->input->post('funTelDdd');
    $vFunTelNumero     = $this->input->post('funTelNumero');
    $vFunCelDdd        = $this->input->post('funCelDdd');
    $vFunCelNumero     = $this->input->post('funCelNumero');
    $vFunEndCep        = $this->input->post('funEndCep');
    $vFunEndTpLgr      = $this->input->post('funEndTpLgr');
    $vFunEndLogradouro = $this->input->post('funEndLogradouro');
    $vFunEndNumero     = $this->input->post('funEndNumero');
    $vFunEndBairro     = $this->input->post('funEndBairro');
    $vFunEndCidade     = $this->input->post('funEndCidade');
    $vFunEndEstado     = $this->input->post('funEndEstado');
    $vFunObs           = $this->input->post('funObservacao');
    $vFunAtivo         = $this->input->post('funAtivo');
    // ======================

    $arrFuncionarioDados = [];
    $arrFuncionarioDados["fun_nome"]           = $vFunNome;
    $arrFuncionarioDados["fun_cpf_cnpj"]       = $vFunCpfCnpj;
    $arrFuncionarioDados["fun_rg_ie"]          = $vFunRgIe;
    $arrFuncionarioDados["fun_tel_ddd"]        = $vFunTelDdd;
    $arrFuncionarioDados["fun_tel_numero"]     = $vFunTelNumero;
    $arrFuncionarioDados["fun_cel_ddd"]        = $vFunCelDdd;
    $arrFuncionarioDados["fun_cel_numero"]     = $vFunCelNumero;
    $arrFuncionarioDados["fun_end_cep"]        = $vFunEndCep;
    $arrFuncionarioDados["fun_end_tp_lgr"]     = $vFunEndTpLgr;
    $arrFuncionarioDados["fun_end_logradouro"] = $vFunEndLogradouro;
    $arrFuncionarioDados["fun_end_numero"]     = $vFunEndNumero;
    $arrFuncionarioDados["fun_end_bairro"]     = $vFunEndBairro;
    $arrFuncionarioDados["fun_end_cidade"]     = $vFunEndCidade;
    $arrFuncionarioDados["fun_end_estado"]     = $vFunEndEstado;
    $arrFuncionarioDados["fun_observacao"]     = $vFunObs;
    $arrFuncionarioDados["fun_ativo"]          = $vFunAtivo;

    $this->load->model('Tb_Funcionario');
    $retInsert = $this->Tb_Funcionario->insert($arrFuncionarioDados);
    $data      = [];

    $this->load->model('Tb_Estado');
    $retEstados = $this->Tb_Estado->getEstados();
    $arrEstados = (!$retEstados["erro"]) ? $retEstados["arrEstados"]: array();

    if( $retInsert["erro"] ){
      $data["arrFuncionarioDados"] = $arrFuncionarioDados;
      $data["errorMsg"]        = isset($retInsert["msg"]) ? $retInsert["msg"]: "Erro ao inserir funcionário!";
      $data["okMsg"]           = "";
    } else {
      $data["arrFuncionarioDados"] = array();
      $data["errorMsg"]        = "";
      $data["okMsg"]           = isset($retInsert["msg"]) ? $retInsert["msg"]: "Funcionário inserido com sucesso!";
    }

    $data["arrEstados"] = $arrEstados;
    $this->template->load('template', 'Funcionario/novo', $data);
  }

  public function editar($funId){
    // esquema para dynatables
    $queries = http_build_query($_GET);

    $this->load->model('Tb_Funcionario');
    $retFuncionario      = $this->Tb_Funcionario->getFuncionario($funId);
    $arrFuncionarioDados = [];
    if(!$retFuncionario["erro"]){
      $arrFuncionarioDados = $retFuncionario["arrFuncionarioDados"];
    }

    $data = [];
    $data["editar"]           = true;
    $data["arrFuncionarioDados"] = $arrFuncionarioDados;
    $data["errorMsg"]         = "";
    $data["okMsg"]            = "";
    $data["queries"]          = $queries;

    $this->load->model('Tb_Estado');
    $retEstados = $this->Tb_Estado->getEstados();
    $arrEstados = (!$retEstados["erro"]) ? $retEstados["arrEstados"]: array();

    $data["arrEstados"] = $arrEstados;
    $this->template->load('template', 'Funcionario/novo', $data);
  }

  public function salvaEditar(){
    $this->load->helper('utils');
    $this->load->model('Tb_Funcionario');

    // variaveis ============
    $vFunId            = $this->input->post('funId');
    $vFunNome          = $this->input->post('funNome');
    $vFunCpfCnpj       = $this->input->post('funCpfCnpj');
    $vFunRgIe          = $this->input->post('funRgIe');
    $vFunTelDdd        = $this->input->post('funTelDdd');
    $vFunTelNumero     = $this->input->post('funTelNumero');
    $vFunCelDdd        = $this->input->post('funCelDdd');
    $vFunCelNumero     = $this->input->post('funCelNumero');
    $vFunEndCep        = $this->input->post('funEndCep');
    $vFunEndTpLgr      = $this->input->post('funEndTpLgr');
    $vFunEndLogradouro = $this->input->post('funEndLogradouro');
    $vFunEndNumero     = $this->input->post('funEndNumero');
    $vFunEndBairro     = $this->input->post('funEndBairro');
    $vFunEndCidade     = $this->input->post('funEndCidade');
    $vFunEndEstado     = $this->input->post('funEndEstado');
    $vFunObs           = $this->input->post('funObservacao');
    $vFunAtivo         = $this->input->post('funAtivo');
    // ======================

    $retFuncionario      = $this->Tb_Funcionario->getFuncionario($vFunId);
    $arrFuncionarioDados = [];
    if(!$retFuncionario["erro"]){
      $arrFuncionarioDados = $retFuncionario["arrFuncionarioDados"];
    }

    $arrFuncionarioDados["fun_id"]             = $vFunId;
    $arrFuncionarioDados["fun_nome"]           = $vFunNome;
    $arrFuncionarioDados["fun_cpf_cnpj"]       = $vFunCpfCnpj;
    $arrFuncionarioDados["fun_rg_ie"]          = $vFunRgIe;
    $arrFuncionarioDados["fun_tel_ddd"]        = $vFunTelDdd;
    $arrFuncionarioDados["fun_tel_numero"]     = $vFunTelNumero;
    $arrFuncionarioDados["fun_cel_ddd"]        = $vFunCelDdd;
    $arrFuncionarioDados["fun_cel_numero"]     = $vFunCelNumero;
    $arrFuncionarioDados["fun_end_cep"]        = $vFunEndCep;
    $arrFuncionarioDados["fun_end_tp_lgr"]     = $vFunEndTpLgr;
    $arrFuncionarioDados["fun_end_logradouro"] = $vFunEndLogradouro;
    $arrFuncionarioDados["fun_end_numero"]     = $vFunEndNumero;
    $arrFuncionarioDados["fun_end_bairro"]     = $vFunEndBairro;
    $arrFuncionarioDados["fun_end_cidade"]     = $vFunEndCidade;
    $arrFuncionarioDados["fun_end_estado"]     = $vFunEndEstado;
    $arrFuncionarioDados["fun_observacao"]     = $vFunObs;
    $arrFuncionarioDados["fun_ativo"]          = $vFunAtivo;

    $retEdit = $this->Tb_Funcionario->edit($arrFuncionarioDados);
    $data    = [];
    if( $retEdit["erro"] ){
      $data["errorMsg"]        = isset($retEdit["msg"]) ? $retEdit["msg"]: "Erro ao editar funcionário!";
      $data["okMsg"]           = "";
    } else {
      $data["errorMsg"]        = "";
      $data["okMsg"]           = isset($retEdit["msg"]) ? $retEdit["msg"]: "Funcionário editado com sucesso!";
    }

    $this->load->model('Tb_Estado');
    $retEstados = $this->Tb_Estado->getEstados();
    $arrEstados = (!$retEstados["erro"]) ? $retEstados["arrEstados"]: array();

    $data["editar"]          = true;
    $data["arrFuncionarioDados"] = $arrFuncionarioDados;
    $data["arrEstados"]      = $arrEstados;
    $this->template->load('template', 'Funcionario/novo', $data);
  }

  public function deletar($funId){
    $data     = [];
    $errorMsg = "";

    $this->load->model('Tb_Funcionario');
    $retFuncionario      = $this->Tb_Funcionario->getFuncionario($funId);
    $arrFuncionarioDados = [];
    if(!$retFuncionario["erro"]){
      $arrFuncionarioDados = $retFuncionario["arrFuncionarioDados"];
    } else {
      $errorMsg = "Erro ao buscar Funcionário ID " . $funId;
    }

    $arrFuncionarioDados["fun_ativo"] = 0;

    $retEdit = $this->Tb_Funcionario->edit($arrFuncionarioDados);
    if( $retEdit["erro"] ){
      $errorMsg = isset($retEdit["msg"]) ? $retEdit["msg"]: "Erro ao editar funcionário!";
    }

    $this->session->set_userdata('FuncionarioIndex_error_msg', $errorMsg);
    $redirect = base_url() . "Funcionario";
    header("location:$redirect");
  }
}
