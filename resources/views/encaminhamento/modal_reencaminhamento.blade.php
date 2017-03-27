<!-- Modal principal de disciplinas -->
<div id="modal_reencaminhamento" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 60%;">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Reencaminhamento da demanda</h4>
            </div>
            {!! Form::open(['route'=>'seracademico.ouvidoria.encaminhamento.reencaminarStore', 'method' => "POST", 'id'=> 'formReencaminhamento' ]) !!}
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row" style="margin-bottom: 5%; background-color: #D3D3D3; border-bottom: #696969 solid;">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12" style="background-color: #e6e9dc">
                                <div class="col-md-4" style="margin-top: 17px">
                                    <span><strong>Demanda: </strong><p>{{$detalheEncaminhamento->codigo}}</p></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group col-md-3">
                                <div class=" fg-line">
                                    <label for="secretaria">Secretaria *</label>
                                    <div class="select">
                                        {!! Form::select('secretaria', (["" => "Selecione"] + $loadFields['ouvidoria\secretaria']->toArray()), $detalheEncaminhamento->area_id, array('class' => 'form-control', 'id' => 'secretaria', 'readonly' => 'readonly')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-5">
                                <div class=" fg-line">
                                    <label for="destinatario_id">Destino *</label>
                                    <div class="select">
                                        {!! Form::select('destinatario_id', array($detalheEncaminhamento->destinatario_id => $detalheEncaminhamento->destinatario), $detalheEncaminhamento->destinatario_id, array('class' => 'form-control', 'id' => 'destinatario_id', 'readonly' => 'readonly')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class=" fg-line">
                                    <label for="prioridade_id">Prioridade *</label>
                                    <div class="select">
                                        {!! Form::select('prioridade_id',  (["" => "Selecione"] + $loadFields['ouvidoria\prioridade']->toArray()), Session::getOldInput('encaminhamento[prioridade_id]'), array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--<div class="row">
                            <div class="form-group col-md-5">
                                <div class="fg-line">
                                    <div class="fg-line">
                                        <label for="encaminhado">Documento Encaminhamento</label>
                                        {!! Form::text('encaminhado', Session::getOldInput('encaminhamento[encaminhado]')  , array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                            </div>
                        </div>--}}
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="form-group">
                                    <div class="fg-line">
                                        <label for="parecer">Comentário/Parecer</label>
                                        <div class="textarea">
                                            {!! Form::textarea('parecer', Session::getOldInput('encaminhamento[parecer]'),
                                                array('class' => 'form-control', 'rows' => '5')) !!}
                                        </div>
                                        <input type="hidden" name="demanda_id" value="{{$detalheEncaminhamento->demanda_id}}">
                                        <input type="hidden" name="id" value="{{$detalheEncaminhamento->id}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->