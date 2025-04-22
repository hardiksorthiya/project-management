<!DOCTYPE html>
<html>
<head>
    <title>Clients PDF</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        td, th { border: 1px solid #333; padding: 8px; font-size: 12px; }
    </style>
</head>
<body>
    <h2>Client List</h2>
    <table>
        <thead>
            <tr>
                <th>Name</th><th>Email</th><th>Phone</th><th>Company</th><th>Address</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clients as $client)
                <tr>
                    <td>{{ $client->name }}</td>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->phone }}</td>
                    <td>{{ $client->company_name }}</td>
                    <td>{{ $client->address }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
