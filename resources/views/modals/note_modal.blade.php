<!-- delete Modal -->
<div id="note-modal" class="modal fade">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h6">{{translate('Give A Note For Status Update')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body text-center">
                <form >


                    <div class="form-group">
                      <label for="exampleFormControlTextarea1">Note For  Order</label>
                      <textarea class="form-control"  name="note" id="note" rows="3"></textarea>
                    </div>
                  </form>
                <!--<button type="button" class="btn btn-link mt-2" data-dismiss="modal">{{translate('Cancel')}}</button>-->
                <button  id="note-btn" class="btn btn-primary mt-2">{{translate('Proceed')}}</button>
            </div>

        </div>
    </div>
</div><!-- /.modal -->
