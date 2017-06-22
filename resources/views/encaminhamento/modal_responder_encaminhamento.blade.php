<!-- Modal principal de disciplinas -->
<div id="modal_responder_encaminhamento" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog"{{-- style="width: 30%;"--}}>
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Responder ao encaminhamento</h4>
            </div>

            <div class="modal-body" style="alignment-baseline: central">

                {{-- Resposta de encaminhamentos passados --}}
                <div class="row">
                    <h4>Respostas de encaminhamentos anteriores</h4>
                    @if(count($respostasPassadas) > 0)
                        @foreach($respostasPassadas as $resposta)
                            <div style="width: 100%; background-color: #eee; border-style: groove; margin-top: 2px">
                                <span><b>Data da resposta: </b>{{$resposta->data}}</span>
                                <p><b>Resposta:</b> {{$resposta->resposta}}</p>
                            </div>
                        @endforeach
                    @else
                        <p>Nenhuma resposta anterior. Você está no primeiro encaminhamento dessa manifestação</p>
                    @endif
                </div> <br />

                {{-- Campo para resposta --}}
                {!! Form::open(['route'=>'seracademico.ouvidoria.encaminhamento.responder', 'method' => "POST", 'id' => 'FormResponder' ]) !!}
                <div class="row">

                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="fg-line">
                                    {!! Form::label('resposta', 'Resposta ao encaminhamento atual') !!}
                                    {!! Form::textarea('resposta', $detalheEncaminhamento->resposta , array('class' => 'form-control', 'rows' => '4')) !!}
                                    <input type="hidden" name="id" value="{{$detalheEncaminhamento->id}}">
                                    <input type="hidden" name="tipo_resposta" value="1">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class="fg-line">
                                    <label for="data">Prazo para solução</label>
                                    <?php $prazoAnterior = isset($encaminhamentoAnterior->prazo_solucao) ? $encaminhamentoAnterior->prazo_solucao : ""; ?>
                                    @if(!$detalheEncaminhamento->prazo_solucao || !$prazoAnterior)
                                        {!! Form::text('data', null, array('class' => 'form-control input-sm date', 'id' => 'data', 'placeholder' => 'Data')) !!}
                                    @elseif ($prazoAnterior)
                                        {!! Form::text('data', $prazoAnterior, array('class' => 'form-control input-sm', 'id' => 'data', 'readonly' => 'readonly', 'placeholder' => 'Data')) !!}
                                    @else

                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @role('ouvidoria|admin')
                            <div class="form-group col-md-5">
                                <label for="resp_publica" class="checkbox checkbox-inline m-r-20">
                                    @if($detalheEncaminhamento->resp_publica == '1')
                                        {!! Form::checkbox('resp_publica', 1, null, ['checked' => 'checked']) !!}
                                    @else
                                        {!! Form::hidden('resp_publica', 0) !!}
                                        {!! Form::checkbox('resp_publica', 1, null, []) !!}
                                    @endif
                                    <i class="input-helper"></i>
                                    Tornar resposta pública?
                                </label>
                            </div>
                            @endrole
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