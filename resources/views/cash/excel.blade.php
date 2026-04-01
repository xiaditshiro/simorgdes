<table>
    <thead>
        <tr>
            <th>Nama Anggota</th>
            @foreach($cash->schedules as $schedule)
                <th>{{ $schedule->due_date->format('d-m-Y') }}</th>
            @endforeach
            <th>Total Lunas</th>
        </tr>
    </thead>
    <tbody>
        @foreach($members as $member)
            @php $total = 0; @endphp
            <tr>
                <td>{{ $member->full_name }}</td>

                @foreach($cash->schedules as $schedule)
                    @php
                        $payment = $paymentMap[$member->id][$schedule->id] ?? null;
                        $paid = $payment && $payment->status === 'paid';
                        if ($paid)
                            $total++;
                    @endphp
                    <td>{{ $paid ? 'Lunas' : 'Belum' }}</td>
                @endforeach

                <td>{{ $total }}</td>
            </tr>
        @endforeach
    </tbody>
</table>