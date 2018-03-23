<div class="modal fade" id="invitation-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('events.invite') }}" method="POST">
            @csrf
            <input type="hidden" name="event_id" id="event_id" value="">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Invitations</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="user" class="col-form-label">Users:</label>
                            <user-select 
                                name="emails" 
                                url="{{ route('users.autoload') }}">
                            </user-select>
                            @if($errors->has('emails'))
                                <span class="form-text text-danger">{{ $errors->get('emails')[0] }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Message:</label>
                            <textarea name="message" class="form-control" id="message-text">{{ old('message') }}</textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Send invitations</button>
                </div>
            </div>
        </form>
    </div>
</div>