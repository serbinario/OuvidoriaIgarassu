<!-- Modal principal de disciplinas -->
<div id="modal_responder_encaminhamento" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog"{{-- style="width: 30%;"--}}>
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Responder ao encaminhamento</h4>
            </div>
            {!! Form::open(['route'=>'seracademico.ouvidoria.encaminhamento.responder', 'method' => "POST" ]) !!}
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="row">
                        <div class="form-group col-md-12">
                            {!! Form::label('resposta', 'Resposta') !!}
                            {!! Form::textarea('resposta', $detalheEncaminhamento->resposta ,['size' => '72x5'] , array('class' => 'form-control')) !!}
                            <input type="hidden" name="id" value="{{$detalheEncaminhamento->id}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="btnSaveHistorico">Salvar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal" id="btnCancelHistorico">Cancelar</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->