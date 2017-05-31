<!-- Modal principal de disciplinas -->
<div id="modal-finalizar-manifestacao" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Finalizar Manifestação</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="status_externo_id">Situação</label>
                            <select name="status_externo_id" class="form-control" id="status_externo_id">
                                <option value="1">Procedente solucionado</option>
                                <option value="2">Improcedente</option>
                                <option value="1">Procedente não solucionado</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="btnFinalizarManifestacao">Salvar</button>
                <button class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->