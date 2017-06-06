<!-- Modal principal de disciplinas -->
<div id="modal_assunto" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog modal-sm" style="width: 60%;">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Cadastrar Assunto</h4>
            </div>
            {!! Form::open(['route'=>'seracademico.ouvidoria.assunto.storeAjax', 'method' => "POST", 'id'=> 'form' ]) !!}
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group col-md-5">
                                <div class="fg-line">
                                    <div class="fg-line">
                                        <label for="nome-assunto">Assunto</label>
                                        {!! Form::text('nome-assunto', Session::getOldInput('nome-assunto')  , array('class' => 'form-control', 'id' => 'nome-assunto')) !!}
                                        <input type="hidden" value="" id="add-assunto-area_id" name="area_id">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="salvar-assunto" class="btn btn-primary">Salvar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->