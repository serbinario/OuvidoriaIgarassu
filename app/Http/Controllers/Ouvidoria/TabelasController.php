<?php

namespace Seracademico\Http\Controllers\Ouvidoria;

use Illuminate\Http\Request;

use Seracademico\Http\Controllers\Controller;
use Seracademico\Http\Requests;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Khill\Lavacharts\Lavacharts;

class TabelasController extends Controller
{

    /**
     * @return mixed
     */
    public function assuntoClassificacao()
    {

        #Criando a consulta
        $rows = \DB::table('ouv_demanda')
            ->join('ouv_subassunto', 'ouv_subassunto.id', '=', 'ouv_demanda.subassunto_id')
            ->join('ouv_assunto', 'ouv_assunto.id', '=', 'ouv_subassunto.assunto_id')
            ->join('ouv_informacao', 'ouv_informacao.id', '=', 'ouv_demanda.informacao_id')
            ->groupBy('ouv_assunto.id', 'ouv_informacao.id')
            ->select([
                'ouv_informacao.nome as info',
                'ouv_assunto.nome as assunto',
                'ouv_assunto.id as assunto_id',
                \DB::raw('count(ouv_demanda.id) as qtd'),
            ])->get();

        $array = [];
        $arrayAssunto = [];
        $count = 0;
        $totalDemandas = 0;

        foreach ($rows as $row) {
            if(in_array($row->assunto, $arrayAssunto)) {
                continue;
            }
            $array[$count]['assunto'] = $row->assunto;
            $arrayAssunto[$count]  = $row->assunto;
            $totalGeral = 0;
            foreach ($rows as $row2) {
                if($row2->assunto_id == $row->assunto_id) {
                    $array[$count][$row2->info] = $row2->qtd;
                    $totalGeral += $row2->qtd;
                }
            }
            $array[$count]['totalGeral'] = $totalGeral;
            $totalDemandas += $totalGeral;
            $count++;
        }

        return view('ouvidoria.tabelas.assuntoClassificacao', compact('array', 'totalDemandas'));
    }


    /**
     * @return string
     */
    public function assuntoView()
    {
        $assuntos = \DB::table('ouv_assunto')->get();
        
        return view('ouvidoria.tabelas.assuntos', ['assuntos' => $assuntos]);
    }

    /**
     * @return string
     */
    public function assuntos(Request $request)
    {
        $dados = $request->request->all();
        $assuntoId = $dados['assunto'];

        $assuntos = \DB::table('ouv_assunto')->get();
        
        $assuntosFirst = \DB::table('ouv_assunto')
            ->where('ouv_assunto.id', '=', $assuntoId)->select(['nome'])->first();

        $subassuntos = \DB::table('ouv_subassunto')
            ->join('ouv_assunto', 'ouv_assunto.id', '=', 'ouv_subassunto.assunto_id')
            ->where('ouv_assunto.id', '=', $assuntoId)->select(['ouv_subassunto.nome', 'ouv_subassunto.id'])->get();

        $rows = \DB::table('ouv_demanda')
            ->join('ouv_subassunto', 'ouv_subassunto.id', '=', 'ouv_demanda.subassunto_id')
            ->join('ouv_assunto', 'ouv_assunto.id', '=', 'ouv_subassunto.assunto_id')
            ->where('ouv_assunto.id', '=', $assuntoId)
            ->groupBy('ouv_demanda.subassunto_id')
            ->select([
                'ouv_subassunto.id as subassunto',
                \DB::raw('count(ouv_demanda.id) as qtd'),
            ])->get();

       //dd($assuntos);

        return view('ouvidoria.tabelas.assuntos', compact('assuntos', 'assuntosFirst','subassuntos', 'rows'));
    }

    /**
     * @return mixed
     */
    public function sexo()
    {
        #Criando a consulta
        $rows = \DB::table('ouv_demanda')
            ->join('sexos', 'sexos.id', '=', 'ouv_demanda.sexos_id')
            ->groupBy('sexos.id')
            ->select([
                'sexos.nome as sexo',
                \DB::raw('count(ouv_demanda.id) as qtd'),
            ])->get();

        $totalDemandas = 0;

        foreach ($rows as $row) {
            $totalDemandas += $row->qtd;
        }

        return view('ouvidoria.tabelas.sexo', compact('rows', 'totalDemandas'));
    }

    /**
     * @return mixed
     */
    public function escolaridade()
    {
        #Criando a consulta
        $rows = \DB::table('ouv_demanda')
            ->join('escolaridade', 'escolaridade.id', '=', 'ouv_demanda.escolaridade_id')
            ->groupBy('escolaridade.id')
            ->select([
                'escolaridade.id as escolaridade',
                \DB::raw('count(ouv_demanda.id) as qtd'),
            ])->get();

        $totalDemandas = 0;

        foreach ($rows as $row) {
            $totalDemandas += $row->qtd;
        }
        
        $escolaridades = \DB::table('escolaridade')->get();

        return view('ouvidoria.tabelas.escolaridade', compact('rows', 'totalDemandas', 'escolaridades'));
    }


    /**
     * @return mixed
     */
    public function comunidadeClassificacao()
    {

        #Criando a consulta
        $rows = \DB::table('ouv_demanda')
            ->join('ouv_comunidade', 'ouv_comunidade.id', '=', 'ouv_demanda.comunidade_id')
            ->join('ouv_informacao', 'ouv_informacao.id', '=', 'ouv_demanda.informacao_id')
            ->groupBy('ouv_comunidade.id', 'ouv_informacao.id')
            ->select([
                'ouv_informacao.nome as info',
                'ouv_comunidade.nome as comunidade',
                'ouv_comunidade.id as comunidade_id',
                \DB::raw('count(ouv_demanda.id) as qtd'),
            ])->get();

        $array = [];
        $arrayComunidade = [];
        $count = 0;
        $totalDemandas = 0;

        foreach ($rows as $row) {
            if(in_array($row->comunidade, $arrayComunidade)) {
                continue;
            }
            $array[$count]['comunidade'] = $row->comunidade;
            $arrayComunidade[$count]  = $row->comunidade;
            $totalGeral = 0;
            foreach ($rows as $row2) {
                if($row2->comunidade_id == $row->comunidade_id) {
                    $array[$count][$row2->info] = $row2->qtd;
                    $totalGeral += $row2->qtd;
                }
            }
            $array[$count]['totalGeral'] = $totalGeral;
            $totalDemandas += $totalGeral;
            $count++;
        }

        return view('ouvidoria.tabelas.comunidadeClassificacao', compact('array', 'totalDemandas'));
    }
}
