<h2>Laporan Kas {{ $cash->title }}</h2>

<p>Organisasi: {{ $cash->organization->name }}</p>
<p>Jumlah Kas: Rp {{ number_format($cash->amount, 0, ',', '.') }}</p>

<table border="1" width="100%" cellpadding="5">
    <tr>
        <th>Nama Anggota</th>

        @foreach($cash->schedules as $schedule)
            <th>{{ $schedule->due_date->format('d-m-Y') }}</th>
        @endforeach
    </tr>

    @foreach($members as $member)
        <tr>
            <td>{{ $member->full_name }}</td>

            @foreach($cash->schedules as $schedule)

                @php
                    $payment = $paymentMap[$member->id][$schedule->id] ?? null;
                @endphp

                <td align="center">
                    {{ $payment && $payment->status == 'paid' ? 'Lunas' : '-' }}
                </td>

            @endforeach
        </tr>
    @endforeach

</table>