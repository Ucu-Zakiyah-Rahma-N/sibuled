<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Timeline Project</title>
    <style>
        <style>body {
            font-family: DejaVu Sans;
            font-size: 11px;
        }

        h2 {
            margin-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #444;
            padding: 5px;
            white-space: nowrap;
        }

        th {
            background: #f0f0f0;
            text-align: center;
        }

        .status-selesai {
            color: green;
            font-weight: bold;
        }

        .status-running {
            color: orange;
            font-weight: bold;
        }

        .status-belum {
            color: #999;
        }
    </style>
    </style>
</head>

<body>

    <h2>Timeline Project</h2>
    <p>Dicetak: {{ $tanggal }}</p>

    <table>
        <thead>
            <tr>
                <th>Perusahaan</th>
                <th>Tahapan</th>
                <th>Rencana Mulai</th>
                <th>Rencana Selesai</th>
                <th>Actual Mulai</th>
                <th>Actual Selesai</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
                    <td>{{ $row['perusahaan'] }}</td>
                    <td>{{ $row['tahapan'] }}</td>
                    <td>{{ $row['rencana_mulai'] }}</td>
                    <td>{{ $row['rencana_selesai'] }}</td>
                    <td>{{ $row['actual_mulai'] }}</td>
                    <td>{{ $row['actual_selesai'] }}</td>
                    <td
                        class="
                    {{ $row['status'] === 'Selesai' ? 'status-selesai' : '' }}
                    {{ $row['status'] === 'Sedang Berjalan' ? 'status-running' : '' }}
                    {{ $row['status'] === 'Belum Mulai' ? 'status-belum' : '' }}
                ">
                        {{ $row['status'] }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
