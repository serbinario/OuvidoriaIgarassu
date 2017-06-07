<!-- Modal principal de disciplinas -->
<div id="modal-prorrogar-manifestacao" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Prorrogar Manifestação</h4>
            </div>
            {!! Form::open(['route'=>'seracademico.ouvidoria.encaminhamento.prorrogarPrazo', 'method' => "POST" ]) !!}
                <div class="modal-body" style="alignment-baseline: central">
                    <div class="row">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="form-group">
                                    <div class="fg-line">
                                        <label for="justificativa">Justificativa da prorrogação</label>
                                        <div class="textarea">
                                            {!! Form::textarea('justificativa', null, array('class' => 'form-control', 'rows' => '5')) !!}
                                        </div>
                                        <input type="hidden" name="id" value="{{$detalheEncaminhamento->id}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="btnProrrogarManifestacao">Prorrogar</button>
                    <button class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->