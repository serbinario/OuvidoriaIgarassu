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
     * @param $id
     * @return mixed
     */
    public function index($id)
    {
        // Pega o template atual para o documento de carta de encaminhamento
        $template = \DB::table('templates')->where('documento_id', 1)->where('status', 1)->select('html')->first();

        // Pega os dados necessário contidos no documentos
        $dados = $this->dados($id);

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
        $parecer = isset($dados['encaminhamento']->parecer) ? $dados['encaminhamento']->parecer : ""; # primeiro parecer do ouvidor


        // Pega o caminho do arquivo
        $empresa = "Serbinario";
        $caminho = base_path("/resources/views/reports/{$empresa}cartaEncaminhamento.blade.php");

        // Abre o arquivo em branco para escrita do conteúdo do arquivo
        $fp = fopen($caminho, "w+");

        // Escreve no arquivo conteúdo do documento
        fwrite($fp, $template->html);

       //Fecha o arquivo
        fclose($fp);

        // Retorno do template e dados do documento
        return \PDF::loadView("reports.{$empresa}cartaEncaminhamento", compact(
            'titulo', 'codigo', 'secretariaId', 'secretario', 'dataManifestacao', 'dataManifestacao', 'protocolo',
            'tipoManifestacao', 'assunto', 'origem', 'tipoUsuario', 'sigiloId', 'nome', 'fone', 'prioridade',
            'prazo', 'relato', 'parecer'
            ))->stream();
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
}
