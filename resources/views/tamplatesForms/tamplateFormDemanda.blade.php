<div class="row">
	<div class="col-md-12">
		<div class="row">
            <div class="col-md-12">

                <!-- Enviando id do usuario logado para o banco -->
                {!! Form::text('user_id', Auth::user()->id ? Auth::user()->id : null, array('class' => 'hidden')) !!}

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#dados" aria-controls="dados" role="tab" data-toggle="tab">Dados Principais</a></li>
                    <li role="presentation"><a href="#perfil" aria-controls="perfil" role="tab" data-toggle="tab">Perfil</a></li>
                    <li role="presentation"><a href="#outros" aria-controls="outros" role="tab" data-toggle="tab">Outras informações</a></li>
                    <li role="presentation"><a href="#encaminhamento" aria-controls="encaminhamento" role="tab" data-toggle="tab">Encaminhamento</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="dados">
                        <br />
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('sigilo_id', 'Sigilo') !!}
                                    {!! Form::select('sigilo_id', $loadFields['ouvidoria\sigilo'], Session::getOldInput('sigilo_id'), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('anonimo_id', 'Anônimo') !!}
                                    {!! Form::select('anonimo_id', $loadFields['ouvidoria\anonimo'], Session::getOldInput('anonimo_id'), array('class' => 'form-control', 'id' => 'anonimo')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    {!! Form::label('nome', 'Nome') !!}
                                    {!! Form::text('nome', Session::getOldInput('nome')  , array('class' => 'form-control', 'id' => 'nome')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    {!! Form::label('email', 'E-mail') !!}
                                    {!! Form::text('email', Session::getOldInput('email')  , array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('fone', 'Fone') !!}
                                    {!! Form::text('fone', Session::getOldInput('fone')  , array('class' => 'form-control telefone')) !!}
                                </div>
                            </div>
                            {{--O campo só aparece em edit, com a condição de que exista $model presente na página.
                            @if(isset($model->id))
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('minicipio', 'Comunidade') !!}
                                        {!! Form::text('minicipio', Session::getOldInput('minicipio')  , array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                            @endif
                            Removido por Felipe 12-01-2017--}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('comunidade_id', 'Comunidade') !!}
                                    {!! Form::select('comunidade_id',(["" => "Selecione"] + $loadFields['ouvidoria\comunidade']->toArray()), Session::getOldInput('comunidade_id'), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    {!! Form::label('endereco', 'Endereço') !!}
                                    {!! Form::text('endereco', Session::getOldInput('endereco')  , array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('numero_end', 'Número') !!}
                                    {!! Form::text('numero_end', Session::getOldInput('numero_end')  , array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('informacao_id', 'O que deseja?') !!}
                                    {!! Form::select('informacao_id',(["" => "Selecione"] + $loadFields['ouvidoria\informacao']->toArray()), Session::getOldInput('informacao_id'), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('area_id', 'Área') !!}
                                    {!! Form::select('area_id', $loadFields['ouvidoria\area'], Session::getOldInput('area_id'), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('situacao_id', 'Status') !!}
                                    {!! Form::select('situacao_id', (["" => "Selecione"] + $loadFields['ouvidoria\situacao']->toArray()), Session::getOldInput('situacao_id'), array('class' => 'form-control', 'id' => 'situacao')) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('tipo_demanda_id', 'Meio de registro') !!}
                                    {!! Form::select('tipo_demanda_id', (["" => "Selecione"] + $loadFields['ouvidoria\tipodemanda']->toArray()), Session::getOldInput('tipo_demanda_id'), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('pessoa_id', 'Perfil') !!}
                                    {!! Form::select('pessoa_id', $loadFields['ouvidoria\ouvpessoa'], Session::getOldInput('pessoa_id'), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('assunto_id', 'Assunto ') !!}
                                    @if(isset($model->subassunto->assunto->id))
                                        {!! Form::select('assunto_id', (["" => "Selecione"] + $loadFields['ouvidoria\assunto']->toArray()), $model->subassunto->assunto->id, array('class' => 'form-control')) !!}
                                    @else
                                        {!! Form::select('assunto_id', (["" => "Selecione"] + $loadFields['ouvidoria\assunto']->toArray()), Session::getOldInput('assunto_id'), array('class' => 'form-control')) !!}
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('subassunto_id', 'Subassunto ') !!}
                                    @if(isset($model->subassunto->id))
                                        {!! Form::select('subassunto_id', array($model->subassunto->id => $model->subassunto->nome), $model->subassunto->id,array('class' => 'form-control')) !!}
                                    @else
                                        {!! Form::select('subassunto_id', array(), Session::getOldInput('subassunto_id'),array('class' => 'form-control')) !!}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    {!! Form::label('relato', 'Relato') !!}
                                    {!! Form::textarea('relato', Session::getOldInput('relato')  ,['size' => '124x5'] , array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="perfil">
                        <br />
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('sexos_id', 'Sexo') !!}
                                    {!! Form::select('sexos_id', (["" => "Não informado"] + $loadFields['sexo']->toArray()), Session::getOldInput('sexos_id'), array('class' => 'form-control')) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('exclusividade_sus_id', 'Utiliza exclusivamente o SUS?') !!}
                                    {!! Form::select('exclusividade_sus_id', (["2" => "Sim"] + $loadFields['ouvidoria\exclusividadesus']->toArray()), Session::getOldInput('exclusividade_sus_id'), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('idade_id', 'Idade') !!}
                                    {!! Form::select('idade_id', $loadFields2['ouvidoria\idade'], Session::getOldInput('idade_id'), array('class' => 'form-control')) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('escolaridade_id', 'Escolaridade') !!}
                                    {!! Form::select('escolaridade_id',  (["1" => "Não informado"] + $loadFields['ouvidoria\escolaridade']->toArray()), Session::getOldInput('escolaridade_id'), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="outros">
                        <br />
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('melhoria_id', 'Melhoria') !!}
                                    {!! Form::select('melhoria_id', (["" => "Selecione"] + $loadFields['ouvidoria\melhoria']->toArray()), Session::getOldInput('melhoria_id'), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    {!! Form::label('melhorias', 'Quais melhorias você identifica na saúde de Igarassu?') !!}
                                    {!! Form::textarea('melhorias', Session::getOldInput('melhorias')  ,['size' => '130x5'] , array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    {!! Form::label('obs', 'Observações') !!}
                                    {!! Form::textarea('obs', Session::getOldInput('obs')  ,['size' => '130x5'] , array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="encaminhamento">
                        <br />
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    {!! Form::label('destinatario_id', 'Destino') !!}
                                    {!! Form::select('encaminhamento[destinatario_id]', (["" => "Selecione"] + $loadFields['ouvidoria\destinatario']->toArray()), Session::getOldInput('destinatario_id'), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('prioridade_id', 'Prioridade') !!}
                                    {!! Form::select('encaminhamento[prioridade_id]',  (["" => "Selecione"] + $loadFields['ouvidoria\prioridade']->toArray()), Session::getOldInput('encaminhamento[prioridade_id]'), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('status_id', 'Status') !!}
                                    {!! Form::select('encaminhamento[status_id]', (["" => "Selecione"] + $loadFields['ouvidoria\status']->toArray()), Session::getOldInput('encaminhamento[status_id]'), array('class' => 'form-control', 'id' => 'encaminhamento')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    {!! Form::label('encaminhado', 'Documento encaminhado') !!}
                                    {!! Form::text('encaminhamento[encaminhado]', Session::getOldInput('encaminhamento[encaminhado]')  , array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('copia', 'Cópia Para') !!}
                                    {!! Form::text('encaminhamento[copia]', Session::getOldInput('encaminhamento[copia]')  , array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    {!! Form::label('parecer', 'Comentário/Parecer') !!}
                                    {!! Form::textarea('encaminhamento[parecer]', Session::getOldInput('encaminhamento[parecer]')  ,['size' => '130x5'] , array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    {!! Form::label('resposta', 'Resposta') !!}
                                    {!! Form::textarea('encaminhamento[resposta]', Session::getOldInput('encaminhamento[resposta]')  ,['size' => '130x5'] , array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
        <div class="row">
            <div class="col-md-3">
                <div class="btn-group btn-group-justified">
                    <div class="btn-group">
                        <a href="{{ route('seracademico.ouvidoria.demanda.index') }}" class="btn btn-primary btn-block"><i
                                    class="fa fa-long-arrow-left"></i> Voltar</a></div>
                    <div class="btn-group">
                        {!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block')) !!}
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>