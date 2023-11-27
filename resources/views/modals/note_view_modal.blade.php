<!-- delete Modal -->
<div id="note-view-modal" class="modal fade">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h6">{{translate('Note For Cancelation')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body text-center">
                <form >
                    <div class="form-group d-felx justify-content-center">
                      <label for="exampleFormControlTextarea1">Notes Log</label>
                      {{-- <textarea class="form-control"  name="note"  rows="3" readonly>

                      </textarea> --}}
                      <div id="note_view" class="d-flex justify-content-center align-items-center" style="width: 100%;"></div>
                    </div>
                  </form>
                <button type="button" class="btn btn-primary mt-2" data-dismiss="modal">{{translate('Close')}}</button>

            </div>

        </div>
    </div>
</div><!-- /.modal -->
