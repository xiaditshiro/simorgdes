<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Kegiatan Organisasi</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h2,
        h3,
        h4 {
            margin: 0 0 10px 0;
        }

        .title {
            text-align: center;
            margin-bottom: 20px;
        }

        .activity-box {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }

        .info-table,
        .attendance-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .info-table td {
            padding: 6px;
            border: 1px solid #000;
        }

        .attendance-table th,
        .attendance-table td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        .attendance-table th {
            background: #f2f2f2;
        }

        .section-title {
            margin-top: 12px;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .empty {
            font-style: italic;
            color: #555;
        }
    </style>
</head>

<body>

    <div class="title">
        <h2>Laporan Kegiatan Organisasi</h2>
        <p>Tanggal Cetak: {{ now()->format('d-m-Y H:i') }}</p>
    </div>

    @forelse($activities as $activity)
        <div class="activity-box">
            <h3>{{ $loop->iteration }}. {{ $activity->title }}</h3>

            <table class="info-table">
                <tr>
                    <td width="25%"><strong>Organisasi</strong></td>
                    <td>{{ $activity->organization?->name ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Tanggal</strong></td>
                    <td>{{ $activity->activity_date ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Status</strong></td>
                    <td>{{ ucfirst($activity->status) }}</td>
                </tr>
                <tr>
                    <td><strong>Lokasi</strong></td>
                    <td>{{ $activity->location ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Deskripsi</strong></td>
                    <td>{{ $activity->description ?? '-' }}</td>
                </tr>
            </table>

            <div class="section-title">Data Absensi</div>

            @if($activity->attendances && $activity->attendances->count())
                <table class="attendance-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="35%">Nama Anggota</th>
                            <th width="25%">Jabatan</th>
                            <th width="20%">Status Kehadiran</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($activity->attendances as $attendance)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $attendance->member?->full_name ?? '-' }}</td>
                                <td>{{ ucfirst($attendance->member?->position ?? '-') }}</td>
                                <td>{{ ucfirst($attendance->status ?? '-') }}</td>
                                <td>{{ $attendance->notes ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="empty">Belum ada data absensi.</p>
            @endif
        </div>
    @empty
        <p>Tidak ada data kegiatan.</p>
    @endforelse

</body>

</html>