<!-- Modal principal de disciplinas -->
<div id="modal_subassunto" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Cadastrar Subassunto</h4>
            </div>
            {!! Form::open(['route'=>'seracademico.ouvidoria.subassunto.storeAjax', 'method' => "POST", 'id'=> 'form' ]) !!}
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="fg-line">
                                    <div class="fg-line">
                                        <label for="nome-subassunto">Subassunto</label>
                                        {!! Form::text('nome-subassunto', Session::getOldInput('nome-subassunto')  , array('class' => 'form-control', 'id' => 'nome-subassunto')) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="salvar-subassunto" class="btn btn-primary">Salvar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->