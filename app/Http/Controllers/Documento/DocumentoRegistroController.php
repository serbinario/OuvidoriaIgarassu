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
     * @param $id
     * @return mixed
     */
    public function index($id)
    {
        // Pega o template atual para o documento de carta de encaminhamento
        $template = \DB::table('ouv_templates')->where('documento_id', 2)->where('status', 1)->select('html')->first();

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

        // Pega o caminho do arquivo
        $empresa = "Serbinario";
        $caminho = base_path("/resources/views/reports/{$empresa}registroDemanda.blade.php");

        //Abre o arquivo em branco para escrita do conteúdo no arquivo
        //$fp = fopen($caminho, "w");

        //Escreve no arquivo conteúdo do documento
        //fwrite($fp, $template->html);

        //Fecha o arquivo
        //fclose($fp);

        // Retorno do template e dados do documento
        return \PDF::loadView("reports.{$empresa}registroDemanda", compact(
            'titulo', 'informacao', 'data_cadastro', 'hora_cadastro', 'protocolo', 'tipo_demanda', 'sigilo',
            'nome', 'sexo', 'fone', 'email', 'idade', 'rg', 'cpf', 'profissao', 'endereco', 'numero_end', 'cidade',
            'bairro', 'cep', 'relato'
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
            ->leftJoin('gen_departamento', 'gen_departamento.id', '=', 'ouv_encaminhamento.destinatario_id')
            ->leftJoin('gen_secretaria', 'gen_secretaria.id', '=', 'gen_departamento.area_id')
            ->join('ouv_informacao', 'ouv_informacao.id', '=', 'ouv_demanda.informacao_id')
            ->leftJoin('gen_bairros', 'gen_bairros.id', '=', 'ouv_demanda.bairro_id')
            ->leftJoin('gen_cidades', 'gen_cidades.id', '=', 'gen_bairros.cidades_id')
            ->leftJoin('ouv_subassunto', 'ouv_subassunto.id', '=', 'ouv_demanda.subassunto_id')
            ->leftJoin('ouv_assunto', 'ouv_assunto.id', '=', 'ouv_subassunto.assunto_id')
            ->leftJoin('ouv_idade', 'ouv_idade.id', '=', 'ouv_demanda.idade_id')
            ->leftJoin('gen_sexo', 'gen_sexo.id', '=', 'ouv_demanda.sexos_id')
            ->leftJoin('gen_escolaridade', 'gen_escolaridade.id', '=', 'ouv_demanda.escolaridade_id')
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
                'gen_departamento.nome as destino',
                'gen_secretaria.nome as area',
                \DB::raw('DATE_FORMAT(ouv_encaminhamento.previsao,"%d/%m/%Y") as previsao'),
                'ouv_informacao.nome as informacao',
                'ouv_assunto.nome as assunto',
                'ouv_subassunto.nome as subassunto',
                'ouv_demanda.nome as nome',
                'gen_bairros.nome as bairro',
                'gen_cidades.nome as cidade',
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
                'gen_sexo.nome as sexo',
                'gen_escolaridade.nome as escolaridade',
                'ouv_demanda.exclusividade_sus_id',
                'ouv_tipo_demanda.nome as tipo_demanda',
                'gen_secretaria.secretario',
                'gen_secretaria.id as area_id',
                'ouv_sigilo.nome as sigilo',
            ])->first();


        // Retornando os dados para  geração do documento
        return array(
            'configuracao' => $configuracaoGeral,
            'manifestacao' => $manifestacao
        );
    }
}
