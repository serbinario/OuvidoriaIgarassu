<div class="row">
	<div class="col-md-12">
		<div class="row">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header" style="background-color: #213a53;">
                        <h2 style="color: white">Identificação
                            {{--<small>Multi-colored: red, blue, green, yellow</small>--}}
                        </h2>
                    </div>

                    <div class="card-body card-padding">
                        <br >
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('sigilo_id', 'Sigilo') !!}
                                    {!! Form::select('sigilo_id', $loadFields['ouvidoria\sigilo'], Session::getOldInput('sigilo_id'), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('anonimo_id', 'Anônimo') !!}
                                    {!! Form::select('anonimo_id', $loadFields['ouvidoria\anonimo'], Session::getOldInput('anonimo_id'), array('class' => 'form-control', 'id' => 'anonimo')) !!}
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" fg-line">
                                    <label for="tipo_resposta_id">Tipo de resposta</label>
                                    <div class="select">
                                        {!! Form::select('tipo_resposta_id', (["" => "Selecione"] + $loadFields['ouvidoria\tiporesposta']->toArray()), null, array('class'=> 'form-control' , 'id' => 'tipo_resposta_id')) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card dados-pessoas">
                    <div class="card-header dados-pessoas" style="background-color: #213a53;">
                        <h2 style="color: white">Dados pessoas
                            {{--<small>Multi-colored: red, blue, green, yellow</small>--}}
                        </h2>
                    </div>

                    <div class="card-body card-padding dados-pessoas">
                        <br >
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    {!! Form::label('nome', 'Nome') !!}
                                    {!! Form::text('nome', Session::getOldInput('nome')  , array('class' => 'form-control', 'id' => 'nome')) !!}
                                    @if(!isset($model->id))
                                        {!! Form::hidden('tipo_demanda_id', '1') !!}
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('fone', 'Fone') !!}
                                    {!! Form::text('fone', Session::getOldInput('fone')  , array('class' => 'form-control telefone')) !!}
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
                            <div class="col-md-6">
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('comunidade_id', 'Comunidade') !!}
                                    {!! Form::select('comunidade_id',(["" => "Selecione"] + $loadFields['ouvidoria\comunidade']->toArray()), Session::getOldInput('comunidade_id'), array('class' => 'form-control input-sm')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('sexos_id', 'Sexo') !!}
                                    {!! Form::select('sexos_id', (["" => "Selecione"] + $loadFields['sexo']->toArray()), Session::getOldInput('sexos_id'), array('class' => 'form-control')) !!}
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('exclusividade_sus_id', 'Utiliza exclusivamente o SUS?') !!}
                                    {!! Form::select('exclusividade_sus_id', $loadFields['ouvidoria\exclusividadesus'], Session::getOldInput('exclusividade_sus_id'), array('class' => 'form-control')) !!}
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
                                    {!! Form::select('escolaridade_id', (["" => "Selecione"] + $loadFields['ouvidoria\escolaridade']->toArray()), Session::getOldInput('escolaridade_id'), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="card">
                    <div class="card-header " style="background-color: #213a53;">
                        <h2 style="color: white">Dados da manifestação
                            {{--<small>Multi-colored: red, blue, green, yellow</small>--}}
                        </h2>
                    </div>

                    <div class="card-body card-padding">
                        <br >
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('pessoa_id', 'Perfil') !!}
                                    {!! Form::select('pessoa_id', $loadFields['ouvidoria\ouvpessoa'], Session::getOldInput('pessoa_id'), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('informacao_id', 'O que deseja?') !!}
                                    {!! Form::select('informacao_id', (["" => "Selecione"] + $loadFields['ouvidoria\informacao']->toArray()), Session::getOldInput('informacao_id'), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <div class="fg-line">
                                    <div class="fg-line">
                                        <label for="data_da_ocorrencia">Data da ocorrência</label>
                                        {!! Form::text('data_da_ocorrencia', Session::getOldInput('data_da_ocorrencia'), array('class' => 'form-control date', 'id' => 'data_da_ocorrencia', 'placeholder' => 'Data da ocorrência')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <div class="fg-line">
                                    <div class="fg-line">
                                        <label for="hora_da_ocorrencia">Hora da ocorrência</label>
                                        {!! Form::text('hora_da_ocorrencia', Session::getOldInput('hora_da_ocorrencia'), array('class' => 'form-control time', 'placeholder' => 'Hora da ocorrência')) !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-3">
                                <div class=" fg-line">
                                    <label for="area_id">Secretaria</label>
                                    <div class="select">
                                        {!! Form::select('area_id', (["" => "Selecione"] + $loadFields['ouvidoria\secretaria']->toArray()), Session::getOldInput('area_id'), array('class' => 'form-control', 'id' => 'area_id')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" fg-line">
                                    <label for="assunto_id">Assunto</label>
                                    <div class="select">
                                        {!! Form::select('assunto_id', array(), Session::getOldInput('assunto_id'), array('class' => 'form-control', 'id' => 'assunto_id')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" fg-line">
                                    <label for="assunto_id">Subassunto</label>
                                    {!! Form::select('subassunto_id', array(), Session::getOldInput('subassunto_id'),array('class' => 'form-control', 'id' => 'subassunto_id')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('relato', 'Relato') !!}
                                    {!! Form::textarea('relato', Session::getOldInput('relato') , array('class' => 'form-control', 'rows' => '5')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-3">
                                <div class=" fg-line">
                                    <label for="melhoria_secretaria">Secretaria</label>
                                    <div class="select">
                                        {!! Form::select('melhoria_secretaria', (["" => "Selecione"] + $loadFields['ouvidoria\secretaria']->toArray()), Session::getOldInput('area_id'), array('class' => 'form-control', 'id' => 'melhoria_secretaria')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <div class=" fg-line">
                                    <label for="melhoria_id">Melhoria</label>
                                    <div class="select">
                                        {!! Form::select('melhoria_id', array(), Session::getOldInput('subassunto_id'),array('class' => 'form-control', 'id' => 'melhoria_id')) !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('melhorias', 'Quais melhorias você identifica?') !!}
                                    {!! Form::textarea('melhorias', Session::getOldInput('melhorias') , array('class' => 'form-control', 'rows' => '5')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('obs', 'Observações') !!}
                                    {!! Form::textarea('obs', Session::getOldInput('obs') , array('class' => 'form-control', 'rows' => '5')) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <button type="submit" class="btn btn-primary btn-sm m-t-10 submit">Enviar</button>
                <a class="btn btn-default btn-sm m-t-10" href="{{ route('seracademico.indexPublico') }}">Voltar</a>

            </div>
		</div>

	</div>
</div>