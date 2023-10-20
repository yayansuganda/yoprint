<!DOCTYPE html>
<html>
<head>
    <meta name="csrf" content="{{ csrf_token() }}">

    <title>File Import</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>

        Pusher.logToConsole = false;

        var pusher = new Pusher('f4e464892a65a5a1ef36', {
            cluster: 'ap1'
        });

        var channel = pusher.subscribe('yoprint-channel');
        channel.bind('yoprint-event', function(data) {
            $("#"+data.id).html(data.progress + " %")
            $("#"+data.status+"-status").html(data.status + " %")
        });
    </script>

</head>
<body>
    <div class="container mt-4">
        <h1>Import Files</h1>

        <div name="form-body" id="form-body">
            {!! Form::model($model ?? [], [
                'route'=>'import.store',
                'method'=>'POST',
                'enctype'=>"multipart/form-data"
            ])
            !!}
                <div class="form-group">
                    <label for="file">Select a File:</label>
                    <input type="file" name="file" class="form-control-file" id="file" accept=".csv">
                </div>
                <a class="btn-simpan btn btn-primary">Import File</a>
            {!! Form::close() !!}
        </div>

        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Time</th>
                    <th>File Name</th>
                    <th>Status</th>
                    <th>Progres</th>
                </tr>
            </thead>
            <tbody id="datatable">
                @foreach ($batches as $item)
                    <tr>
                        <td>{{ date('Y-m-d H:i:s', $item->created_at)  }}</td>
                        <td>{{ $item->name }}</td>
                        <td><label id="{{ $item->id."-status" }}">{{ $item->pending_jobs != 0 ? "Pending" : ($item->failed_jobs != 0 ? "Failed" : "Completed") }}</label></td>
                        <td><label id="{{ $item->id }}">{{ $item->pending_jobs != 0 ? "0 %" : ($item->failed_jobs != 0 ? " - " : "100 %") }}</label></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="{{ url("/") }}/ajax/package.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
