<div class="row">
	<div class="col-md-12">
		<div class="row">
            <div class="col-md-12">


                <div class="card">
                    <div class="card-header" style="background-color: #0b8345;">
                        <h2 style="color: white">Identificação
                            {{--<small>Multi-colored: red, blue, green, yellow</small>--}}
                        </h2>
                    </div>

                    <div class="card-body card-padding">
                        <br >
                        <div class="row">
                            <div class="col-md-3">
                                <div class="radio m-b-15">
                                    <label>
                                        <input type="radio" id="sigilo-1" name="sigilo_id" value="2">
                                        <i class="input-helper"></i>
                                        "Desejo me identificar"
                                    </label>
                                </div>
                                <div class="radio m-b-15">
                                    <label>
                                        <input type="radio" id="sigilo-2" name="sigilo_id" value="1">
                                        <i class="input-helper"></i>
                                        "Desejo sigilo"
                                    </label>
                                </div>
                            </div>
                            {{--<div class="form-group col-md-4">
                                <div class=" fg-line">
                                    <label for="tipo_resposta_id">Tipo de resposta</label>
                                    <div class="select">
                                        {!! Form::select('tipo_resposta_id', (["" => "Selecione"] + $loadFields['ouvidoria\tiporesposta']->toArray()), null, array('class'=> 'form-control' , 'id' => 'tipo_resposta_id')) !!}
                                    </div>
                                </div>
                            </div>--}}
                        </div>
                    </div>
                </div>

                <div class="card dados-pessoas">
                    <div class="card-header dados-pessoas" style="background-color: #0b8345;">
                        <h2 style="color: white">Dados pessoais
                            {{--<small>Multi-colored: red, blue, green, yellow</small>--}}
                        </h2>
                    </div>

                    <div class="card-body card-padding dados-pessoas">
                        <br >
                        <div class="row">

                            <div class="form-group col-md-8">
                                <div class=" fg-line">
                                    <label for="nome">Nome *</label>
                                    {!! Form::text('nome', Session::getOldInput('nome')  , array('class' => 'form-control', 'id' => 'nome')) !!}
                                    @if(!isset($model->id))
                                        {!! Form::hidden('tipo_demanda_id', '1') !!}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group col-md-2">
                                <div class=" fg-line">
                                    <label for="sexos_id">Sexo *</label>
                                    <div class="select">
                                        {!! Form::select('sexos_id', (["" => "Selecione"] + $loadFields['sexo']->toArray()), Session::getOldInput('sexos_id'), array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-2">
                                <div class=" fg-line">
                                    <label for="idade_id">Idade *</label>
                                    <div class="select">
                                        {!! Form::select('idade_id', $loadFields2['ouvidoria\idade'], Session::getOldInput('idade_id'), array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-2">
                                <div class="fg-line">
                                    {!! Form::label('cpf', 'CPF *') !!}
                                    {!! Form::text('cpf', Session::getOldInput('cpf'), array('class' => 'form-control input-sm cpf', 'placeholder' => 'CPF')) !!}
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <div class="fg-line">
                                    {!! Form::label('rg', 'RG *') !!}
                                    {!! Form::text('rg', Session::getOldInput('rg'), array('class' => 'form-control input-sm', 'placeholder' => 'RG')) !!}
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <div class="fg-line">
                                    {!! Form::label('fone', 'Fone *') !!}
                                    {!! Form::text('fone', Session::getOldInput('fone')  , array('class' => 'form-control telefone')) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('email', 'E-mail') !!}
                                    {!! Form::text('email', Session::getOldInput('email')  , array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-8">
                                <div class="fg-line">
                                    {!! Form::label('profissao', 'Profissão *') !!}
                                    {!! Form::text('profissao', Session::getOldInput('profissao')  , array('class' => 'form-control', 'id' => 'profissao')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class="fg-line">
                                    {!! Form::label('endereco', 'Endereço *') !!}
                                    {!! Form::text('endereco', Session::getOldInput('endereco')  , array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <div class="fg-line">
                                    {!! Form::label('numero_end', 'Número *') !!}
                                    {!! Form::text('numero_end', Session::getOldInput('numero_end')  , array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <div class="fg-line">
                                    {!! Form::label('cep', 'CEP') !!}
                                    {!! Form::text('cep', Session::getOldInput('cep'), array('class' => 'form-control input-sm', 'placeholder' => 'CEP')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-3">
                                <div class="fg-line">
                                    <label class="control-label" for="cidade">Cidade *</label>
                                    <div class="select">
                                        {!! Form::select('cidade', (["" => "Selecione"] + $loadFields['cidade']->toArray()), Session::getOldInput('cidade'),array('class' => 'form-control', 'id' => 'cidade')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-sm-3">
                                <div class="fg-line">
                                    <label class="control-label" for="bairro">Bairro *</label>
                                    <div class="select">
                                        {!! Form::select('bairro_id', array(), Session::getOldInput('bairro_id'),array('class' => 'form-control', 'id' => 'bairro')) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card">
                    <div class="card-header " style="background-color: #0b8345;">
                        <h2 style="color: white">Dados da manifestação
                            {{--<small>Multi-colored: red, blue, green, yellow</small>--}}
                        </h2>
                    </div>

                    <div class="card-body card-padding">
                        <br >
                        <div class="row">

                            <div class="form-group col-md-4">
                                <div class=" fg-line">
                                    <label for="pessoa_id">Autor da manifestação *</label>
                                    <div class="select">
                                        {!! Form::select('pessoa_id', $loadFields['ouvidoria\ouvpessoa'], Session::getOldInput('pessoa_id'), array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <div class=" fg-line">
                                    <label for="informacao_id">Tipo de manifestação *</label>
                                    <div class="select">
                                        {!! Form::select('informacao_id', (["" => "Selecione"] + $loadFields['ouvidoria\informacao']->toArray()), Session::getOldInput('informacao_id'), array('class' => 'form-control')) !!}
                                    </div>
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
                            <div class="col-md-12" id="msg-sigilo">
                                <span style="color: red">
                                        * Para garantir o sigilo, Não coloque seu nome no campo de descrição da manifestação , seus dados ficarão restritos só a ouvidoria
                                </span>
                            </div>
                            <div class="form-group col-md-12">
                                <div class=" fg-line">
                                    <label for="relato">Descrição da manifestação *</label>
                                    {!! Form::textarea('relato', Session::getOldInput('relato') , array('class' => 'form-control', 'rows' => '5')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-offset-4 col-md-12">
                                {!! App('captcha')->display($attributes = [], $lang = 'pt-BR') !!}
                                {{--<div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div>--}}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" id="submit"  class="btn btn-primary btn-sm m-t-10 submit">Registrar Manifestação</button>
                                <a class="btn btn-default btn-sm m-t-10" href="{{ route('seracademico.indexPublico') }}">Voltar</a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
		</div>

	</div>
</div>