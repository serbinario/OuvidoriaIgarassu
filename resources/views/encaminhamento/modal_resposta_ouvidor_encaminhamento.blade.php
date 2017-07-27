<!-- Modal principal de disciplinas -->
<div id="modal_resposta_ouvidor_encaminhamento" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog"{{-- style="width: 30%;"--}}>
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Responder como ouvidor ao encaminhamento</h4>
            </div>

            <div class="modal-body" style="alignment-baseline: central">

                {{-- Resposta de encaminhamentos passados --}}
                <div class="row">
                    <h4>Respostas de encaminhamentos anteriores</h4>
                    @if(count($respostasPassadas) > 0)
                        @foreach($respostasPassadas as $resposta)
                            <div style="width: 100%; background-color: #eee; border-style: groove; margin-top: 2px">
                                <span><b>Data da resposta: </b>{{$resposta->data}}</span>
                                <p><b>Resposta:</b> {{$resposta->resposta_ouvidor}}</p>
                            </div>
                        @endforeach
                    @else
                        <p>Nenhuma resposta anterior. Você está no primeiro encaminhamento dessa manifestação</p>
                    @endif
                </div> <br />

                {{-- Campo para resposta --}}
                {!! Form::open(['route'=>'seracademico.ouvidoria.encaminhamento.responder', 'method' => "POST", 'id' => 'FormResponderOuvidor' ]) !!}
                <div class="row">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <div class="fg-line">
                                {!! Form::label('resposta_ouvidor', 'Resposta do ouvidor ao encaminhamento atual') !!}
                                {!! Form::textarea('resposta_ouvidor', $detalheEncaminhamento->resposta_ouvidor , array('class' => 'form-control', 'rows' => '4')) !!}
                                <input type="hidden" name="id" value="{{$detalheEncaminhamento->id}}">
                                <input type="hidden" name="tipo_resposta" value="2">
                                {{--<input type="hidden" name="data" value="
                                @if($detalheEncaminhamento->prazo_solucao) {{ $detalheEncaminhamento->prazo_solucao }}
                                @elseif ($prazoAnterior)   ">--}}
                            </div>
                        </div>
                        {{--<div class="form-group col-md-5">
                            <label for="resp_ouvidor_publica" class="checkbox checkbox-inline m-r-20">
                                @if($detalheEncaminhamento->resp_ouvidor_publica == '1')
                                    {!! Form::checkbox('resp_ouvidor_publica', 1, null, ['checked' => 'checked']) !!}
                                @else
                                    {!! Form::hidden('resp_ouvidor_publica', 0) !!}
                                    {!! Form::checkbox('resp_ouvidor_publica', 1, null, []) !!}
                                @endif
                                <i class="input-helper"></i>
                                Tornar essa resposta pública?
                            </label>
                        </div>--}}
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