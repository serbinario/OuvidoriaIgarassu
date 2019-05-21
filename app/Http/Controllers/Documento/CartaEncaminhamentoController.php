<?php

namespace Seracademico\Http\Controllers\Documento;

use Illuminate\Http\Request;

use Seracademico\Http\Controllers\Controller;
use Seracademico\Services\Configuracao\ConfiguracaoGeralService;
use Seracademico\Uteis\GerarPDF;


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
        $template = \DB::table('ouv_templates')->where('documento_id', 1)->where('status', 1)->select('html')->first();

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
        $responsavel = isset($dados['manifestacao']->responsavel) ? $dados['manifestacao']->responsavel : "";
        $departamento = $dados['manifestacao']->departamento;


        // Pega o caminho do arquivo
        $empresa = "Serbinario";

//        dd(base_path("/resources/views/reports/{$empresa}cartaEncaminhamento.blade.php"));
        $caminho = base_path("/resources/views/reports/{$empresa}cartaEncaminhamento.blade.php");

        // Abre o arquivo em branco para escrita do conteúdo do arquivo
        $fp = fopen($caminho, "w+");

        // Escreve no arquivo conteúdo do documento
        fwrite($fp, $template->html);

        //Fecha o arquivo
        fclose($fp);

        // Retorno do template e dados do documento
        $view = \View::make("reports.{$empresa}cartaEncaminhamento", compact(
            'titulo', 'codigo', 'secretariaId', 'secretario', 'dataManifestacao', 'dataManifestacao', 'protocolo',
            'tipoManifestacao', 'assunto', 'origem', 'tipoUsuario', 'sigiloId', 'nome', 'fone', 'prioridade',
            'prazo', 'relato', 'parecer', 'responsavel', 'departamento'
        ));

        $view_content = $view->render();

        $pdf = new GerarPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $urlImagemTopo = base_path("/public/img/ouvidoria-saude-logo.png");
        $urlImagemRodape = base_path("/public/img/logo_redape_igarassu.png");

        // Setando os parametros dinâmicos para montar o calendário
        $pdf->setTitulo($titulo);
        $pdf->setUrlImagemTopo($urlImagemTopo);
        $pdf->setUrlImagemRodape($urlImagemRodape);

        $pdf->SetAuthor('Nicola Asuni');
        $pdf->SetTitle('Carta de encaminhamento');
        $pdf->SetSubject('');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $pdf->SetFont('dejavusans', '', 9, '', true);

        $pdf->AddPage();

        $pdf->writeHTML($view_content, true, false, true, false, '');

        $pdf->Output('carta_encaminhamento.pdf');
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
            ->leftJoin('gen_departamento', 'gen_departamento.id', '=', 'ouv_encaminhamento.destinatario_id')
            ->leftJoin('gen_secretaria', 'gen_secretaria.id', '=', 'gen_departamento.area_id')
            ->leftJoin('gen_secretaria as secretaria_dm', 'secretaria_dm.id', '=', 'ouv_encaminhamento.secretaria_id')
            ->leftJoin('ouv_status', 'ouv_status.id', '=', 'ouv_encaminhamento.status_id')
            ->join('ouv_informacao', 'ouv_informacao.id', '=', 'ouv_demanda.informacao_id')
            ->leftJoin('gen_bairros', 'gen_bairros.id', '=', 'ouv_demanda.bairro_id')
            ->leftJoin('ouv_subassunto', 'ouv_subassunto.id', '=', 'ouv_demanda.subassunto_id')
            ->leftJoin('ouv_assunto', 'ouv_assunto.id', '=', 'ouv_subassunto.assunto_id')
            ->join('ouv_tipo_demanda', 'ouv_tipo_demanda.id', '=', 'ouv_demanda.tipo_demanda_id')
            ->join('ouv_pessoa', 'ouv_pessoa.id', '=', 'ouv_demanda.pessoa_id')
            ->where('ouv_demanda.id', '=', $id)
            ->select([
                'ouv_encaminhamento.id as encaminhamento_id',
                \DB::raw('CONCAT (SUBSTRING(ouv_demanda.codigo, 4, 4), "/", SUBSTRING(ouv_demanda.codigo, -4, 4)) as codigo'),
                'ouv_encaminhamento.data',
                'ouv_prioridade.nome as prioridade',
                'ouv_prioridade.dias as prazo',
                'gen_departamento.nome as destino',
                \DB::raw('IF(gen_secretaria.nome != "", gen_secretaria.nome, secretaria_dm.nome) as area'),
                \DB::raw('DATE_FORMAT(ouv_encaminhamento.previsao,"%d/%m/%Y") as previsao'),
                'ouv_status.nome as status',
                'ouv_status.id as status_id',
                'ouv_informacao.nome as informacao',
                'ouv_assunto.nome as assunto',
                'ouv_subassunto.nome as subassunto',
                'ouv_demanda.nome',
                'gen_bairros.nome as bairro',
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
                \DB::raw('IF(gen_secretaria.secretario != "", gen_secretaria.secretario, secretaria_dm.secretario) as secretario'),
                \DB::raw('IF(gen_secretaria.id != "", gen_secretaria.id, secretaria_dm.id) as area_id'),
                'gen_departamento.responsavel',
                'gen_departamento.nome as departamento'
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
