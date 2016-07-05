<div class="row">
	<div class="col-md-12">
		<div class="row">
            <div class="col-md-12">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#dados" aria-controls="dados" role="tab" data-toggle="tab">Dados Principais</a></li>
                    <li role="presentation"><a href="#perfil" aria-controls="perfil" role="tab" data-toggle="tab">Perfil</a></li>
                    <li role="presentation"><a href="#outros" aria-controls="outros" role="tab" data-toggle="tab">Outras informações</a></li>
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('minicipio', 'Comunidade') !!}
                                    {!! Form::text('minicipio', Session::getOldInput('minicipio')  , array('class' => 'form-control')) !!}
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
                                    {!! Form::select('situacao_id', $loadFields['ouvidoria\situacao'], Session::getOldInput('situacao_id'), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('tipo_demanda_id', 'Meio de registro') !!}
                                    {!! Form::select('tipo_demanda_id', $loadFields['ouvidoria\tipodemanda'], Session::getOldInput('tipo_demanda_id'), array('class' => 'form-control')) !!}
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
                                    {!! Form::select('sexos_id', $loadFields['sexo'], Session::getOldInput('sexos_id'), array('class' => 'form-control')) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('exclusividade_sus_id', 'Utiliza exclusivamente o SUS?') !!}
                                    {!! Form::select('exclusividade_sus_id', $loadFields['ouvidoria\exclusividadesus'], Session::getOldInput('exclusividade_sus_id'), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('idade_id', 'Idade') !!}
                                    {!! Form::select('idade_id', $loadFields['ouvidoria\idade'], Session::getOldInput('idade_id'), array('class' => 'form-control')) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('escolaridade_id', 'Escolaridade') !!}
                                    {!! Form::select('escolaridade_id', $loadFields['ouvidoria\escolaridade'], Session::getOldInput('escolaridade_id'), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="outros">
                        <br />
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