<?php

namespace Seracademico\Http\Controllers\Documento;

use Illuminate\Http\Request;

use Seracademico\Http\Controllers\Controller;
use Seracademico\Services\Configuracao\ConfiguracaoGeralService;

class CartaEncaminhamentoController extends Controller
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
    public function index($id)
    {
        // Pega o template atual para o documento de carta de encaminhamento
        $template = \DB::table('templates')->where('documento_id', 1)->where('status', 1)->select('html')->first();

        // Pega os dados necessário contidos no documentos
        $dados = $this->dados($id);

        // Pega os dados já tratados para exibição no documento
        $retorno = $this->tratamentoDosDados($dados);

        // Monta todo o conteúdo do documento
        $conteudo = str_replace($retorno['palavras'], $retorno['variavies'], $template->html);

        // Retorno do template e dados do documento
        return \PDF::loadView('reports.cartaEncaminhamento', compact('conteudo'))->stream();
    }

    /**
     * @param $dados
     * @return array
     */
    public function tratamentoDosDados($dados)
    {
        // Organizando os dados a serem enviados ao documento
        $titulo = $dados['configuracao']->nome; # Nome estabelecido na configutação do sistema
        $codigo = $dados['manifestacao']->codigo;
        $secretariaId = $dados['manifestacao']->area_id;
        $secretario = $dados['manifestacao']->secretario;
        $dataManifestacao = $dados['manifestacao']->dataRegistro; # data de registro da manifestação
        $protocolo = $dados['manifestacao']->n_protocolo;
        $tipoManifestacao = $dados['manifestacao']->tipoManifestacao;
        $assunto = $dados['manifestacao']->assunto;
        $origem = $dados['manifestacao']->origem; # Meio usado para registrar a manifestação
        $tipoUsuario = $dados['manifestacao']->tipoUsuario; # Se cidadão, funcionário e etc.
        $sigiloId = $dados['manifestacao']->sigilo_id;
        $nome = $dados['manifestacao']->nome; # nome do manifestante
        $fone = $dados['manifestacao']->fone;
        $prioridade = $dados['manifestacao']->prioridade;
        $prazo = $dados['manifestacao']->prazo; # dias para solução do problema de acordo com prioridade
        $relato = $dados['manifestacao']->relato; # relato do manifestante
        $parecer = $dados['encaminhamento']->parecer; # primeiro parecer do ouvidor

        // Palavras reservadas de modo estático no documento para ser substituída pelos dados reais do banco
        $palavras = array(
            '$titulo$',
            '$codigo$',
            '$secretaria$',
            '$secretario$',
            '$data$',
            '$protocolo$',
            '$tipoManifestacao$',
            '$assunto$',
            '$origem$',
            '$tipoUsuario$',
            '$nome$',
            '$fone$',
            '$prioridade$',
            '$prazo$',
            '$relato$',
            '$parecer$',
        );

        ## Regras para tratamento dos dados a serem tratados antes de serem exibidos

        // Validada se o documento está sendo encaminhado para o prefeito ou para outra secretaria
        if ($secretariaId == '3') {
            $secretaria = "Gabinte do Prefeitro";
            $secretario = "V.Ex.ª " . $secretario;
        } else {
            $secretaria = "Ao secretário(a)";
            $secretario = "Dr(a) " . $secretario;
        }

        // Define a data da manifestação por extenso caso a data esteja definida
        if ($dataManifestacao) {
            $data = \DateTime::createFromFormat('Y-m-d', $dataManifestacao);
            $dataFormatada = $this->dataPorExtenso($data->format('d'), $data->format('m'), $data->format('Y'), $data->format('w'));
        } else {
            $dataFormatada = "";
        }

        // Pega o nome do manifestante caso não seja sigiloso
        $nome = $sigiloId == 2 ? 'Confidencial' : $nome;

        // Variaveis que iram substituir a palavras reservadas no documento
        $variavies = array(
            $titulo,
            $codigo,
            $secretaria,
            $secretario,
            $dataFormatada,
            $protocolo,
            $tipoManifestacao,
            $assunto,
            $origem,
            $tipoUsuario,
            $nome,
            $fone,
            $prioridade,
            $prazo,
            $relato,
            $parecer,
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
            ->leftJoin('ouv_prioridade', 'ouv_prioridade.id', '=', 'ouv_encaminhamento.prioridade_id')
            ->leftJoin('ouv_destinatario', 'ouv_destinatario.id', '=', 'ouv_encaminhamento.destinatario_id')
            ->leftJoin('ouv_area', 'ouv_area.id', '=', 'ouv_destinatario.area_id')
            ->leftJoin('ouv_status', 'ouv_status.id', '=', 'ouv_encaminhamento.status_id')
            ->join('ouv_informacao', 'ouv_informacao.id', '=', 'ouv_demanda.informacao_id')
            ->leftJoin('bairros', 'bairros.id', '=', 'ouv_demanda.bairro_id')
            ->leftJoin('ouv_subassunto', 'ouv_subassunto.id', '=', 'ouv_demanda.subassunto_id')
            ->leftJoin('ouv_assunto', 'ouv_assunto.id', '=', 'ouv_subassunto.assunto_id')
            ->join('ouv_tipo_demanda', 'ouv_tipo_demanda.id', '=', 'ouv_demanda.tipo_demanda_id')
            ->join('ouv_pessoa', 'ouv_pessoa.id', '=', 'ouv_demanda.pessoa_id')
            ->where('ouv_demanda.id', '=', $id)
            ->select([
                'ouv_encaminhamento.id as encaminhamento_id',
                \DB::raw('CONCAT (SUBSTRING(ouv_demanda.codigo, 4, 4), "/", SUBSTRING(ouv_demanda.codigo, -4, 4)) as codigo'),
                //\DB::raw('DATE_FORMAT(ouv_encaminhamento.data,"%d/%m/%Y") as data'),
                'ouv_encaminhamento.data',
                'ouv_prioridade.nome as prioridade',
                'ouv_prioridade.dias as prazo',
                'ouv_destinatario.nome as destino',
                'ouv_area.nome as area',
                \DB::raw('DATE_FORMAT(ouv_encaminhamento.previsao,"%d/%m/%Y") as previsao'),
                'ouv_status.nome as status',
                'ouv_status.id as status_id',
                'ouv_informacao.nome as informacao',
                'ouv_assunto.nome as assunto',
                'ouv_subassunto.nome as subassunto',
                'ouv_demanda.nome',
                'bairros.nome as bairro',
                'ouv_demanda.endereco',
                'ouv_demanda.numero_end',
                'ouv_demanda.id',
                'ouv_demanda.fone',
                'ouv_demanda.relato',
                'ouv_demanda.obs',
                'ouv_demanda.n_protocolo',
                'ouv_demanda.data as dataRegistro',
                'ouv_encaminhamento.resposta',
                'ouv_encaminhamento.parecer',
                'ouv_demanda.sigilo_id',
                'ouv_informacao.nome as tipoManifestacao',
                'ouv_tipo_demanda.nome as origem',
                'ouv_pessoa.nome as tipoUsuario',
                'ouv_area.secretario',
                'ouv_area.id as area_id'
            ])->first();

        // Pega o primeiro encaminhamento da manifestação
        $encaminhamento = \DB::table('ouv_encaminhamento')
            ->where('ouv_encaminhamento.demanda_id', $manifestacao->id)->select([
                'ouv_encaminhamento.parecer',
            ])->first();


        // Retornando os dados para  geração do documento
        return array(
            'configuracao' => $configuracaoGeral,
            'manifestacao' => $manifestacao,
            'encaminhamento' => $encaminhamento
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
