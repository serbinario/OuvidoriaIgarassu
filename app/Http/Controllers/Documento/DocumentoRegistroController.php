<?php

namespace Seracademico\Http\Controllers\Documento;

use Illuminate\Http\Request;

use Seracademico\Http\Controllers\Controller;
use Seracademico\Services\Configuracao\ConfiguracaoGeralService;

class DocumentoRegistroController extends Controller
{

    /**
     * @var ConfiguracaoGeralService
     */
    private $configuracaoGeralService;

    /**
     * @param ConfiguracaoGeralService $configuracaoGeralService
     */
    public function __construct(ConfiguracaoGeralService $configuracaoGeralService)
    {
        $this->configuracaoGeralService = $configuracaoGeralService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index2($id)
    {
        // Pega o template atual para o documento de carta de encaminhamento
        $template = \DB::table('templates')->where('documento_id', 2)->where('status', 1)->select('html')->first();

        // Pega os dados necessário contidos no documentos
        $dados = $this->dados($id);

        // Pega os dados já tratados para exibição no documento
        $retorno = $this->tratamentoDosDados($dados);

        // Monta todo o conteúdo do documento
        $conteudo = str_replace($retorno['palavras'], $retorno['variavies'], $template->html);

        // Retorno do template e dados do documento
        return \PDF::loadView('reports.registroDemanda', compact('conteudo'))->stream();
    }

    public function index($id)
    {
        // Pega o template atual para o documento de carta de encaminhamento
        $template = \DB::table('templates')->where('documento_id', 2)->where('status', 1)->select('html')->first();

        // Pega os dados necessário contidos no documentos
        $dados = $this->dados($id);

        $titulo = $dados['configuracao']->nome; # Nome estabelecido na configutação do sistema
        $informacao = $dados['manifestacao']->informacao;
        $data_cadastro = $dados['manifestacao']->data_cadastro;
        $hora_cadastro = $dados['manifestacao']->hora_cadastro;
        $protocolo = $dados['manifestacao']->n_protocolo;
        $tipo_demanda = $dados['manifestacao']->tipo_demanda;
        $sigilo = $dados['manifestacao']->sigilo;
        $nome = $dados['manifestacao']->nome; # nome do manifestante
        $sexo = $dados['manifestacao']->sexo;
        $fone = $dados['manifestacao']->fone;
        $email = $dados['manifestacao']->email;
        $idade = $dados['manifestacao']->idade;
        $rg = $dados['manifestacao']->rg;
        $cpf = $dados['manifestacao']->cpf;
        $profissao = $dados['manifestacao']->profissao;
        $endereco = $dados['manifestacao']->endereco;
        $numero_end = $dados['manifestacao']->numero_end;
        $cidade = $dados['manifestacao']->cidade;
        $bairro = $dados['manifestacao']->bairro;
        $cep = $dados['manifestacao']->cep;
        $relato = $dados['manifestacao']->relato;

        //Abre o arquivo em branco para escrita do conteúdo do arquivo
        $fp = fopen("D:/LOCALHOST/SerOuvidoriaAbreu/resources/views/reports/registroDemanda.blade.php", "w");

        //Escreve no arquivo conteúdo do documento
        fwrite($fp, $template->html);

        //Fecha o arquivo
        fclose($fp);

        // Retorno do template e dados do documento
        return \PDF::loadView('reports.registroDemanda', compact(
            'titulo', 'informacao', 'data_cadastro', 'hora_cadastro', 'protocolo', 'tipo_demanda', 'sigilo',
            'nome', 'sexo', 'fone', 'email', 'idade', 'rg', 'cpf', 'profissao', 'endereco', 'numero_end', 'cidade',
            'bairro', 'cep', 'relato'
        ))->stream();

    }

    /**
     * @param $dados
     * @return array
     */
    public function tratamentoDosDados($dados)
    {
        // Organizando os dados a serem enviados ao documento
        $titulo = $dados['configuracao']->nome; # Nome estabelecido na configutação do sistema
        $informacao = $dados['manifestacao']->informacao;
        $data_cadastro = $dados['manifestacao']->data_cadastro;
        $hora_cadastro = $dados['manifestacao']->hora_cadastro;
        $protocolo = $dados['manifestacao']->n_protocolo;
        $tipo_demanda = $dados['manifestacao']->tipo_demanda;
        $sigilo = $dados['manifestacao']->sigilo;
        $nome = $dados['manifestacao']->nome; # nome do manifestante
        $sexo = $dados['manifestacao']->sexo;
        $fone = $dados['manifestacao']->fone;
        $email = $dados['manifestacao']->email;
        $idade = $dados['manifestacao']->idade;
        $rg = $dados['manifestacao']->rg;
        $cpf = $dados['manifestacao']->cpf;
        $profissao = $dados['manifestacao']->profissao;
        $endereco = $dados['manifestacao']->endereco;
        $numero_end = $dados['manifestacao']->numero_end;
        $cidade = $dados['manifestacao']->cidade;
        $bairro = $dados['manifestacao']->bairro;
        $cep = $dados['manifestacao']->cep;
        $relato = $dados['manifestacao']->relato;

        // Palavras reservadas de modo estático no documento para ser substituída pelos dados reais do banco
        $palavras = array(
            '$titulo$',
            '$informacao$',
            '$data_cadastro$',
            '$hora_cadastro$',
            '$protocolo$',
            '$tipo_demanda$',
            '$sigilo$',
            '$nome$',
            '$sexo$',
            '$fone$',
            '$email$',
            '$idade$',
            '$rg$',
            '$cpf$',
            '$profissao$',
            '$endereco$',
            '$numero_end$',
            '$cidade$',
            '$bairro$',
            '$cep$',
            '$relato$',
        );


        // Variaveis que iram substituir a palavras reservadas no documento
        $variavies = array(
            $titulo,
            $informacao,
            $data_cadastro,
            $hora_cadastro,
            $protocolo,
            $tipo_demanda,
            $sigilo,
            $nome,
            $sexo,
            $fone,
            $email,
            $idade,
            $rg,
            $cpf,
            $profissao,
            $endereco,
            $numero_end,
            $cidade,
            $bairro,
            $cep,
            $relato
        );

        return ['palavras' => $palavras, 'variavies' => $variavies];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dados($id)
    {
        // Consulta os dados das configurações gerais do sistema
        $configuracaoGeral = $this->configuracaoGeralService->findConfiguracaoGeral();

        // Consulta os dados da manifestação
        $manifestacao = \DB::table('ouv_demanda')
            ->leftJoin(\DB::raw('ouv_encaminhamento'), function ($join) {
                $join->on(
                    'ouv_encaminhamento.id', '=',
                    \DB::raw("(SELECT encaminhamento.id FROM ouv_encaminhamento as encaminhamento
                        where encaminhamento.demanda_id = ouv_demanda.id AND encaminhamento.status_id IN (1,7,2,4,6) ORDER BY ouv_encaminhamento.id DESC LIMIT 1)")
                );
            })
            ->leftJoin('ouv_destinatario', 'ouv_destinatario.id', '=', 'ouv_encaminhamento.destinatario_id')
            ->leftJoin('ouv_area', 'ouv_area.id', '=', 'ouv_destinatario.area_id')
            ->join('ouv_informacao', 'ouv_informacao.id', '=', 'ouv_demanda.informacao_id')
            ->leftJoin('bairros', 'bairros.id', '=', 'ouv_demanda.bairro_id')
            ->leftJoin('cidades', 'cidades.id', '=', 'bairros.cidades_id')
            ->leftJoin('ouv_subassunto', 'ouv_subassunto.id', '=', 'ouv_demanda.subassunto_id')
            ->leftJoin('ouv_assunto', 'ouv_assunto.id', '=', 'ouv_subassunto.assunto_id')
            ->leftJoin('ouv_idade', 'ouv_idade.id', '=', 'ouv_demanda.idade_id')
            ->leftJoin('sexos', 'sexos.id', '=', 'ouv_demanda.sexos_id')
            ->leftJoin('escolaridade', 'escolaridade.id', '=', 'ouv_demanda.escolaridade_id')
            ->leftJoin('ouv_tipo_demanda', 'ouv_tipo_demanda.id', '=', 'ouv_demanda.tipo_demanda_id')
            ->leftJoin('ouv_pessoa', 'ouv_pessoa.id', '=', 'ouv_demanda.pessoa_id')
            ->leftJoin('ouv_sigilo', 'ouv_sigilo.id', '=', 'ouv_demanda.sigilo_id')
            ->where('ouv_demanda.id', '=', $id)
            ->select([
                'ouv_encaminhamento.id as encaminhamento_id',
                \DB::raw('CONCAT (SUBSTRING(ouv_demanda.codigo, 4, 4), "/", SUBSTRING(ouv_demanda.codigo, -4, 4)) as codigo'),
                \DB::raw('DATE_FORMAT(ouv_encaminhamento.data,"%d/%m/%Y") as data'),
                \DB::raw('DATE_FORMAT(ouv_demanda.data_da_ocorrencia,"%d/%m/%Y") as data_da_ocorrencia'),
                \DB::raw('DATE_FORMAT(ouv_demanda.data,"%d/%m/%Y") as data_cadastro'),
                \DB::raw('DATE_FORMAT(ouv_demanda.data,"%H:%m:%s") as hora_cadastro'),
                'ouv_demanda.hora_da_ocorrencia',
                'ouv_destinatario.nome as destino',
                'ouv_area.nome as area',
                \DB::raw('DATE_FORMAT(ouv_encaminhamento.previsao,"%d/%m/%Y") as previsao'),
                'ouv_informacao.nome as informacao',
                'ouv_assunto.nome as assunto',
                'ouv_subassunto.nome as subassunto',
                'ouv_demanda.nome as nome',
                'bairros.nome as bairro',
                'cidades.nome as cidade',
                'ouv_demanda.endereco',
                'ouv_demanda.n_protocolo',
                'ouv_demanda.numero_end',
                'ouv_demanda.fone',
                'ouv_demanda.relato',
                'ouv_demanda.obs',
                'ouv_demanda.email',
                'ouv_demanda.rg',
                'ouv_demanda.cpf',
                'ouv_demanda.profissao',
                'ouv_demanda.cep',
                'ouv_pessoa.nome as autor',
                'ouv_encaminhamento.resposta',
                'ouv_encaminhamento.parecer',
                'ouv_demanda.sigilo_id',
                'ouv_demanda.anonimo_id',
                'ouv_idade.nome as idade',
                'sexos.nome as sexo',
                'escolaridade.nome as escolaridade',
                'ouv_demanda.exclusividade_sus_id',
                'ouv_tipo_demanda.nome as tipo_demanda',
                'ouv_area.secretario',
                'ouv_area.id as area_id',
                'ouv_sigilo.nome as sigilo',
            ])->first();


        // Retornando os dados para  geração do documento
        return array(
            'configuracao' => $configuracaoGeral,
            'manifestacao' => $manifestacao
        );
    }

    /**
     * @param $dia
     * @param $mes
     * @param $ano
     * @param $semana
     * @return string
     */
    public function dataPorExtenso($dia, $mes, $ano, $semana) {

        // configuração mes
        switch ($mes){

            case 1: $mes = "Janeiro"; break;
            case 2: $mes = "Fevereiro"; break;
            case 3: $mes = "Março"; break;
            case 4: $mes = "Abril"; break;
            case 5: $mes = "Maio"; break;
            case 6: $mes = "Junho"; break;
            case 7: $mes = "Julho"; break;
            case 8: $mes = "Agosto"; break;
            case 9: $mes = "Setembro"; break;
            case 10: $mes = "Outubro"; break;
            case 11: $mes = "Novembro"; break;
            case 12: $mes = "Dezembro"; break;

        }


        // configuração semana
        switch ($semana) {

            case 0: $semana = "Domingo"; break;
            case 1: $semana = "Segunda Feira"; break;
            case 2: $semana = "Terçaa Feira"; break;
            case 3: $semana = "Quarta Feira"; break;
            case 4: $semana = "Quinta Feira"; break;
            case 5: $semana = "Sexta Feira"; break;
            case 6: $semana = "Sábado"; break;

        }

        return "$dia de $mes de $ano";

    }
}
