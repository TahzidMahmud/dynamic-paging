
<div class="d-flex justofy-content-center align-items-center" >
    <table class="table ">
        <thead>
            <th>Status</th>
            <th>Note</th>
            <th>By</th>
            <th>Date Time</th>
        </thead>
        <tbody>
            @foreach ($notes as $note )

            <tr>
                <td>{{ $note->status??'Not Provided' }}</td>
                <td>{{ $note->note }}</td>
                <td>{{ $note->user->name }}</td>
                <td>{{ Carbon\Carbon::parse($note->created_at)->format('d-m-Y  h:s:i A') }}</td>
            </tr>

            @endforeach

        </tbody>
    </table>
</div>




