<div class="block-header">
    <h2>Configuração Geral</h2>
</div>
<div class="card">
    <div class="card-body card-padding">
        <div class="row">
            <div class="col-md-12">

                <div class="row">
                    <div class="form-group col-md-4">
                        <div class="fg-line">
                            <div class="fg-line">
                                <label for="nome">Nome *</label>
                                {!! Form::text('nome', Session::getOldInput('nome') , array('class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        <div class="fg-line">
                            <div class="fg-line">
                                <label for="instituicao">instituicao *</label>
                                {!! Form::text('instituicao', Session::getOldInput('instituicao') , array('class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        <div class="fg-line">
                            <div class="fg-line">
                                <label for="cnpj">CNPJ *</label>
                                {!! Form::text('cnpj', Session::getOldInput('cnpj') , array('class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-8">
                        <div class="fg-line">
                            <div class="fg-line">
                                <label for="nome_ouvidor">Nome Ouvidor *</label>
                                {!! Form::text('nome_ouvidor', Session::getOldInput('nome_ouvidor') , array('class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        <div class="fg-line">
                            <div class="fg-line">
                                <label for="cargo">Cargo *</label>
                                {!! Form::text('cargo', Session::getOldInput('cargo') , array('class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-12">
                        <div class="fg-line">
                            <div class="fg-line">
                                <label for="texto_agradecimento">Texto de agradecimento</label>
                                {!! Form::textarea('texto_agradecimento', Session::getOldInput('texto_agradecimento') ,
                                    array('class' => 'form-control', 'rows'=>'5')) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-12">
                        <div class="fg-line">
                            <div class="fg-line">
                                <label for="texto_ende_horario_atend">Endereço e horário de atendimento</label>
                                {!! Form::textarea('texto_ende_horario_atend', Session::getOldInput('texto_ende_horario_atend') ,
                                    array('class' => 'form-control', 'rows'=>'5')) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-4">
                        <div class="fg-line">
                            <div class="fg-line">
                                <label for="telefone1">Telefone1</label>
                                {!! Form::text('telefone1', Session::getOldInput('telefone1') ,
                                    array('class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        <div class="fg-line">
                            <div class="fg-line">
                                <label for="telefone2">Telefone2</label>
                                {!! Form::text('telefone2', Session::getOldInput('telefone2') ,
                                    array('class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        <div class="fg-line">
                            <div class="fg-line">
                                <label for="pagina_principal">Página princpal *</label>
                                {!! Form::text('pagina_principal', Session::getOldInput('pagina_principal') ,
                                    array('class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-8">
                        <div class="fg-line">
                            <div class="fg-line">
                                <label for="email">E-mail *</label>
                                {!! Form::text('email', Session::getOldInput('email') ,
                                    array('class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        <div class="fg-line">
                            <div class="fg-line">
                                <label for="senha">Senha *</label>
                                {!! Form::text('senha', Session::getOldInput('senha') ,
                                    array('class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <div class="fg-line">
                            <div class="fg-line">
                                <label for="acesso_principal">Acesso principal</label>
                                {!! Form::text('acesso_principal', Session::getOldInput('acesso_principal') ,
                                    array('class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <div class="fg-line">
                            <div class="fg-line">
                                <label for="consulta_externa">Consulta externa</label>
                                {!! Form::text('consulta_externa', Session::getOldInput('consulta_externa') ,
                                    array('class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <button class="btn btn-primary btn-sm m-t-10">Salvar</button>
            </div>
        </div>
    </div>
</div>

@section('javascript')
    <script type="text/javascript" src="{{ asset('/dist/js/messages_pt_BR.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/dist/js/validacao/adicional/alphaSpace.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/lib/jquery-validation/src/additional/integer.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/validacoes/configuracaoGeral.js')}}"></script>
@endsection